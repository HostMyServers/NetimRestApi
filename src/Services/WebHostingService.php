<?php

namespace HostMyServers\NetimRestApi\Services;

/**
 * Service to manage web hosting through the Netim API.
 */
class WebHostingService extends BaseService
{
    /**
     * Retrieves information about a specific web hosting.
     *
     * @param string $hostingId ID of the hosting to retrieve.
     * @return array Hosting information.
     * @throws NetimException If an error occurs during the request.
     */
    public function getHostingInfo(string $hostingId): array
    {
        return $this->request('GET', 'hosting/' . $hostingId);
    }

    /**
     * Creates a new web hosting.
     *
     * @param array $hostingData Hosting data to create.
     * @return array Creation result.
     * @throws NetimException If an error occurs during the request.
     */
    public function createHosting(array $hostingData): array
    {
        return $this->request('POST', 'hosting', [
            'json' => $hostingData,
        ]);
    }

    // Add other web hosting related methods here...
}
