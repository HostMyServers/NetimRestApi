<?php

namespace HostMyServers\NetimRestApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use HostMyServers\NetimRestApi\Exceptions\NetimException;
use Psr\Log\LoggerInterface;

/**
 * Base class for all services, providing common functionalities.
 */
abstract class BaseService
{
    protected Client $httpClient;
    protected ?LoggerInterface $logger;

    public function __construct(Client $httpClient, LoggerInterface $logger = null)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    protected function request(string $method, string $endpoint, array $options = [], bool $asArray = false): array|object|string
    {
        try {
            if ($this->logger) {
                $this->logger->info("Request to Netim API", [
                    'method' => $method,
                    'endpoint' => $endpoint,
                    'options' => $options,
                ]);
            }

            $response = $this->httpClient->request($method, $endpoint, $options);
            $data = json_decode($response->getBody()->getContents(), $asArray);

            if ($this->logger) {
                $this->logger->info("Response from Netim API", ['response' => $data]);
            }

            if ($asArray) {
                if (isset($data['error'])) {
                    $errorMessage = $data['error']['message'] ?? 'An unknown error occurred.';
                    $apiErrorCode = $data['error']['code'] ?? null;
                    $apiErrorData = $data['error']['data'] ?? null;
                    throw new NetimException($errorMessage, $apiErrorCode, $apiErrorData);
                }
            } else {
                if (isset($data->error)) {
                    $errorMessage = $data->error->message ?? 'An unknown error occurred.';
                    $apiErrorCode = $data->error->code ?? null;
                    $apiErrorData = $data->error->data ?? null;
                    throw new NetimException($errorMessage, $apiErrorCode, $apiErrorData);
                }
            }

            return $data;
        } catch (GuzzleException $e) {
            if ($this->logger) {
                $this->logger->error("HTTP request failed", ['exception' => $e]);
            }
            throw new NetimException('HTTP request failed: ' . $e->getMessage(), null, null, $e->getCode(), $e);
        }
    }
}
