<?php

namespace HostMyServers\NetimRestApi\Services;

class DomainService extends BaseService
{
    /**
     * Get domain information
     */
    public function getDomainInfo(string $domain): object
    {
        return $this->request('GET', sprintf('domain/%s/info/', $domain));
    }

    /**
     * Check domain availability
     */
    public function checkDomain(string $domain): object
    {
        return $this->request('GET', sprintf('domain/%s/check/', $domain));
    }

    /**
     * Check multiple domains availability
     */
    public function checkMultipleDomains(array $domains): object
    {
        return $this->request('POST', 'domain/check/', [
            'json' => ['domains' => $domains]
        ]);
    }

    /**
     * Register a new domain
     */
    public function createDomain(array $domainData): object
    {
        return $this->request('POST', 'domain', [
            'json' => $domainData
        ]);
    }

    /**
     * Transfer a domain to Netim
     */
    public function transferDomain(string $domain, array $transferData): object
    {
        return $this->request('POST', sprintf('domain/%s/transfer/', $domain), [
            'json' => $transferData
        ]);
    }

    /**
     * Renew a domain
     */
    public function renewDomain(string $domain, int $period): object
    {
        return $this->request('POST', sprintf('domain/%s/renew/', $domain), [
            'json' => ['period' => $period]
        ], true);
    }

    /**
     * Update domain DNS servers
     */
    public function updateDNS(string $domain, array $nameservers): object
    {
        return $this->request('PUT', sprintf('domain/%s/dns/', $domain), [
            'json' => ['nameservers' => $nameservers]
        ]);
    }

    /**
     * Get DNS servers for a domain
     */
    public function getDNS(string $domain): object
    {
        return $this->request('GET', sprintf('domain/%s/dns/', $domain));
    }

    /**
     * Enable/Disable WHOIS privacy
     */
    public function setWhoisPrivacy(string $domain, bool $enabled): object
    {
        return $this->request('PUT', sprintf('domain/%s/whois-privacy/', $domain), [
            'json' => ['enabled' => $enabled]
        ]);
    }

    /**
     * Get WHOIS privacy status
     */
    public function getWhoisPrivacy(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/whois-privacy/', $domain), [], true);
    }

    /**
     * Enable/Disable auto-renewal
     */
    public function setAutoRenew(string $domain, bool $enabled): object
    {
        return $this->request('PUT', sprintf('domain/%s/auto-renew/', $domain), [
            'json' => ['enabled' => $enabled]
        ]);
    }

    /**
     * Get auto-renewal status
     */
    public function getAutoRenew(string $domain): object
    {
        return $this->request('GET', sprintf('domain/%s/auto-renew/', $domain));
    }

    /**
     * Get domain WHOIS information
     */
    public function getWhois(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/whois/', $domain), [], true);
    }

    /**
     * Delete a domain
     */
    public function deleteDomain(string $domain): object
    {
        return $this->request('DELETE', sprintf('domain/%s/', $domain), [
            'json' => ['typeDelete' => 'NOW']
        ]);
    }

    /**
     * Get list of all domains
     */
    public function getDomainsList(): object
    {
        return $this->request('GET', 'domain/list/');
    }

    /**
     * Configure DNSSEC for a domain
     */
    public function setDNSSEC(string $domain, array $dnssecData): object
    {
        return $this->request('PUT', sprintf('domain/%s/dnssec/', $domain), [
            'json' => $dnssecData
        ]);
    }

    /**
     * Get DNSSEC configuration
     */
    public function getDNSSEC(string $domain): object
    {
        return $this->request('GET', sprintf('domain/%s/dnssec/', $domain));
    }

    /**
     * Update domain lock status
     */
    public function setDomainLock(string $domain, string $locked): object
    {
        return $this->request('PATCH', sprintf('domain/%s/preference/', $domain), [
            'json' => [
                'codePref' => 'registrar_lock',
                'value' => $locked
            ]
        ]);
    }

    /**
     * Request auth code for domain transfer
     */
    public function requestAuthCode(string $domain, int $sendtoregistrant): object
    {
        return $this->request('PATCH', sprintf('domain/%s/authid/', $domain), [
            'json' => ['sendtoregistrant' => $sendtoregistrant]
        ]);
    }

    /**
     * Restore an expired domain
     */
    public function restoreDomain(string $domain): object
    {
        return $this->request('POST', sprintf('domain/%s/restore/', $domain));
    }
}
