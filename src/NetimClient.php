<?php

namespace HostMyServers\NetimRestApi;

use GuzzleHttp\Client;
use HostMyServers\NetimRestApi\Services\TldService;
use HostMyServers\NetimRestApi\Services\ZonesService;
use HostMyServers\NetimRestApi\Services\DomainService;
use HostMyServers\NetimRestApi\Services\ContactService;
use HostMyServers\NetimRestApi\Services\WebHostingService;

class NetimClient
{
    protected string $apiUrl;
    protected Client $httpClient;
    protected ?string $sessionToken = null;
    protected bool $sessionClosed = false;

    // Service instances
    public DomainService $domain;
    public ContactService $contact;
    public WebHostingService $webHosting;
    public TldService $tld;
    public ZonesService $zones;

    /**
     * NetimClient class constructor.
     */
    public function __construct()
    {
        $login = config('netim.login');
        $secret = config('netim.secret');
        $language = config('netim.language', 'FR');
        $this->apiUrl = config('netim.api_url');

        if (!$login || !$secret) {
            throw new \RuntimeException('Netim credentials (login and secret) are required');
        }

        // Initialize the initial session with Basic Auth
        $this->initSession($login, $secret);

        // Configure the client with the session token
        $this->httpClient = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'Accept-Language' => strtoupper($language),
                'Authorization' => 'Bearer ' . $this->sessionToken,
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->domain = new DomainService($this->httpClient);
        $this->zones = new ZonesService($this->httpClient);
        $this->contact = new ContactService($this->httpClient);
        $this->tld = new TldService($this->httpClient);
        // $this->webHosting = new WebHostingService($this->httpClient);
    }

    /**
     * Initialize a session with Netim API
     */
    protected function initSession(string $login, string $secret): void
    {
        try {
            $tempClient = new Client([
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'Accept-Language' => 'EN',
                    'Authorization' => 'Basic ' . base64_encode("$login:$secret"),
                    'Content-Type' => 'application/json',
                ],
            ]);

            $response = $tempClient->post('session/');
            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['access_token'])) {
                throw new \RuntimeException('Session token not received from Netim API');
            }

            $this->sessionToken = $data['access_token'];
        } catch (\Exception $e) {
            throw new \RuntimeException('Netim session initialization failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the current session token
     */
    public function getSessionToken(): ?string
    {
        return $this->sessionToken;
    }

    /**
     * Close the active session with Netim API
     */
    public function closeSession(): void
    {
        if ($this->sessionClosed || !$this->sessionToken) {
            return;
        }

        try {
            $tempClient = new Client([
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->sessionToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $response = $tempClient->delete('session/');
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $this->sessionClosed = true;
                $this->sessionToken = null;
            }
        } catch (\Exception $e) {
            error_log('Error while closing Netim session: ' . $e->getMessage());
        } finally {
            $this->sessionToken = null;
            $this->sessionClosed = true;
        }
    }

    /**
     * Ensure session is closed when object is destroyed
     */
    public function __destruct()
    {
        if (!$this->sessionClosed) {
            $this->closeSession();
        }
    }

    /**
     * Check if session is active
     */
    public function hasActiveSession(): bool
    {
        return !$this->sessionClosed && $this->sessionToken !== null;
    }

    /**
     * Force session renewal
     */
    public function renewSession(): void
    {
        $this->closeSession();
        $this->initSession(config('netim.login'), config('netim.secret'));
    }
}
