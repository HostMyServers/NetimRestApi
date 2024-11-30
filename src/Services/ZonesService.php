<?php

namespace HostMyServers\NetimRestApi\Services;

/**
 * Service to manage DNS zones and associated services via the Netim API.
 */
class ZonesService extends BaseService
{
    /**
     * Initialize a DNS zone for a domain
     */
    public function initializeDnsZone(string $domain, array $options = []): object
    {
        return $this->request('POST', sprintf('domain/%s/zone/init/', $domain), [
            'json' => $options
        ]);
    }

    /**
     * Initialize SOA record for a domain
     */
    public function initializeSoaRecord(string $domain, array $options = []): object
    {
        return $this->request('POST', sprintf('domain/%s/zone/soa/init/', $domain), [
            'json' => $options
        ]);
    }

    /**
     * Create a DNS zone for a domain
     */
    public function createDnsZone(string $domain, array $records): object
    {
        return $this->request('POST', sprintf('domain/%s/zone/', $domain), [
            'json' => $records
        ]);
    }

    /**
     * Delete the DNS zone of a domain
     */
    public function deleteDnsZone(string $domain, $records): object
    {
        return $this->request('DELETE', sprintf('domain/%s/zone/', $domain), [
            'json' => $records
        ]);
    }

    /**
     * Get the list of DNS records
     */
    public function getDnsRecordsList(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/zone/', $domain));
    }

    /**
     * Create an email forward for a domain
     */
    public function createMailForward(string $domain, string $source, string $destination): object
    {
        return $this->request('POST', sprintf('domain/%s/fwd/mail/', $domain), [
            'json' => [
                'source' => $source,
                'destination' => $destination
            ]
        ]);
    }

    /**
     * Delete an email forward
     */
    public function deleteMailForward(string $domain, string $source): object
    {
        return $this->request('DELETE', sprintf('domain/%s/fwd/mail/%s/', $domain, $source));
    }

    /**
     * Get the list of email forwards
     */
    public function getMailForwardsList(string $domain): object
    {
        return $this->request('GET', sprintf('domain/%s/fwd/mail/', $domain));
    }

    /**
     * Create a web forward for a domain
     */
    public function createWebForward(string $domain, string $source, string $destination, array $options = []): object
    {
        return $this->request('POST', sprintf('domain/%s/fwd/web/', $domain), [
            'json' => array_merge([
                'source' => $source,
                'destination' => $destination
            ], $options)
        ]);
    }

    /**
     * Delete a web forward
     */
    public function deleteWebForward(string $domain, string $source): object
    {
        return $this->request('DELETE', sprintf('domain/%s/fwd/web/%s/', $domain, $source));
    }

    /**
     * Get the list of web forwards
     */
    public function getWebForwardsList(string $domain): object
    {
        return $this->request('GET', sprintf('domain/%s/fwd/web/', $domain));
    }
}
