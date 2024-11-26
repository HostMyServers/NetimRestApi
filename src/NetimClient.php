<?php

namespace HostMyServers\NetimRestApi;

use GuzzleHttp\Client;
use HostMyServers\NetimRestApi\Services\DomainService;
use HostMyServers\NetimRestApi\Services\WebHostingService;

class NetimClient
{
    protected string $apiUrl = 'https://api.netim.com/v2/';
    protected string $apiKey;
    protected Client $httpClient;

    // Instances des services
    public DomainService $domain;
    public WebHostingService $webHosting;
    // Ajoutez d'autres services ici

    /**
     * Constructeur de la classe NetimClient.
     *
     * @param string $apiKey Clé API fournie par Netim.
     * @param array $config Configuration supplémentaire pour le client HTTP.
     */
    public function __construct(string $apiKey, array $config = [])
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new Client(array_merge([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'X-API-KEY' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ], $config));

        $this->domain = new DomainService($this->httpClient);
        $this->webHosting = new WebHostingService($this->httpClient);
    }
}

