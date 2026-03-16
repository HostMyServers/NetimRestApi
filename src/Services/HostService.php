<?php

namespace HostMyServers\NetimRestApi\Services;

class HostService extends BaseService
{
    /**
     * Create a new host
     *
     * At least one IP address (ipv4 or ipv6) must be provided.
     */
    public function createHost(string $host, array $ipv4 = [], array $ipv6 = []): object
    {
        $data = ['host' => $host];
        if (!empty($ipv4)) {
            $data['ipv4'] = $ipv4;
        }
        if (!empty($ipv6)) {
            $data['ipv6'] = $ipv6;
        }

        return $this->request('POST', 'host/', ['json' => $data]);
    }

    /**
     * Get list of hosts matching a filter
     *
     * Use * as wildcard (e.g. "ns1.*" or "*.example.com").
     */
    public function getHostsList(string $filter = '*'): array
    {
        return $this->request('GET', sprintf('hosts/%s', $filter), [], true);
    }

    /**
     * Update a host's IP addresses
     *
     * At least one IP address (ipv4 or ipv6) must be provided.
     */
    public function updateHost(string $host, array $ipv4 = [], array $ipv6 = []): object
    {
        $data = [];
        if (!empty($ipv4)) {
            $data['ipv4'] = $ipv4;
        }
        if (!empty($ipv6)) {
            $data['ipv6'] = $ipv6;
        }

        return $this->request('PATCH', sprintf('host/%s', $host), ['json' => $data]);
    }

    /**
     * Delete a host
     *
     * A host can only be deleted if no domain names use it.
     */
    public function deleteHost(string $host): object
    {
        return $this->request('DELETE', sprintf('host/%s/', $host));
    }
}
