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

    public function __construct(Client $httpClient, ?LoggerInterface $logger = null)
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
            $body = $response->getBody()->getContents();

            // A response with no body at all (a 204, or a delete that answers nothing) is a
            // legitimate empty answer, not a parse failure.
            if (trim($body) === '') {
                if ($this->logger) {
                    $this->logger->info("Response from Netim API", ['response' => null]);
                }

                return $asArray ? [] : new \stdClass();
            }

            $data = json_decode($body, $asArray);

            if ($this->logger) {
                $this->logger->info("Response from Netim API", ['response' => $data]);
            }

            // A 2xx carrying something that is not a JSON array, object or string — an empty
            // decode, a maintenance or proxy page served as 200, a bare scalar — used to reach
            // the typed return and raise a TypeError. A TypeError is an Error, not an
            // Exception: it went through every catch (\Exception) around a Netim call and came
            // out as a 500, or as an interrupted command, where a fallback was in place.
            if (!is_array($data) && !is_object($data) && !is_string($data)) {
                throw new NetimException(
                    'Unexpected response from Netim API: ' . self::bodyExcerpt($body),
                    null,
                    null,
                    $response->getStatusCode()
                );
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

    /**
     * Enough of the body to tell a maintenance page from a truncated payload, on one line.
     */
    private static function bodyExcerpt(string $body): string
    {
        $excerpt = trim((string) preg_replace('/\s+/', ' ', $body));

        return mb_strlen($excerpt) > 200 ? mb_substr($excerpt, 0, 200) . '…' : $excerpt;
    }
}
