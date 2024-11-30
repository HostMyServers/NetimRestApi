<?php

namespace HostMyServers\NetimRestApi\Services;

class DomainService extends BaseService
{
    /**
     * Get domain information
     */
    public function getDomainInfo(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/info/', $domain));
    }

    /**
     * Check domain availability
     */
    public function checkDomain(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/check/', $domain));
    }

    /**
     * Check multiple domains availability
     */
    public function checkMultipleDomains(array $domains): array
    {
        return $this->request('POST', 'domain/check/', [
            'json' => ['domains' => $domains]
        ]);
    }

    /**
     * Register a new domain
     */
    public function createDomain(array $domainData): array
    {
        return $this->request('POST', 'domain', [
            'json' => $domainData
        ]);
    }

    /**
     * Transfer a domain to Netim
     */
    public function transferDomain(string $domain, array $transferData): array
    {
        return $this->request('POST', sprintf('domain/%s/transfer/', $domain), [
            'json' => $transferData
        ]);
    }

    /**
     * Renew a domain
     */
    public function renewDomain(string $domain, array $renewData): array
    {
        return $this->request('POST', sprintf('domain/%s/renew/', $domain), [
            'json' => $renewData
        ]);
    }

    /**
     * Update domain DNS servers
     */
    public function updateDNS(string $domain, array $nameservers): array
    {
        return $this->request('PUT', sprintf('domain/%s/dns/', $domain), [
            'json' => ['nameservers' => $nameservers]
        ]);
    }

    /**
     * Get DNS servers for a domain
     */
    public function getDNS(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/dns/', $domain));
    }

    /**
     * Update domain contacts
     */
    public function updateContacts(string $domain, array $contacts): array
    {
        return $this->request('PUT', sprintf('domain/%s/contacts/', $domain), [
            'json' => $contacts
        ]);
    }

    /**
     * Get domain contacts
     */
    public function getContacts(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/contacts/', $domain));
    }

    /**
     * Enable/Disable WHOIS privacy
     */
    public function setWhoisPrivacy(string $domain, bool $enabled): array
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
        return $this->request('GET', sprintf('domain/%s/whois-privacy/', $domain));
    }

    /**
     * Enable/Disable auto-renewal
     */
    public function setAutoRenew(string $domain, bool $enabled): array
    {
        return $this->request('PUT', sprintf('domain/%s/auto-renew/', $domain), [
            'json' => ['enabled' => $enabled]
        ]);
    }

    /**
     * Get auto-renewal status
     */
    public function getAutoRenew(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/auto-renew/', $domain));
    }

    /**
     * Get domain WHOIS information
     */
    public function getWhois(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/whois/', $domain));
    }

    /**
     * Delete a domain
     */
    public function deleteDomain(string $domain): array
    {
        return $this->request('DELETE', sprintf('domain/%s/', $domain));
    }

    /**
     * Get list of all domains
     */
    public function getDomainsList(): array
    {
        return $this->request('GET', 'domain/list/');
    }

    /**
     * Configure DNSSEC for a domain
     */
    public function setDNSSEC(string $domain, array $dnssecData): array
    {
        return $this->request('PUT', sprintf('domain/%s/dnssec/', $domain), [
            'json' => $dnssecData
        ]);
    }

    /**
     * Get DNSSEC configuration
     */
    public function getDNSSEC(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/dnssec/', $domain));
    }

    /**
     * Update domain lock status
     */
    public function setDomainLock(string $domain, bool $locked): array
    {
        return $this->request('PUT', sprintf('domain/%s/lock/', $domain), [
            'json' => ['locked' => $locked]
        ]);
    }

    /**
     * Get domain lock status
     */
    public function getDomainLock(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/lock/', $domain));
    }

    /**
     * Request auth code for domain transfer
     */
    public function requestAuthCode(string $domain): array
    {
        return $this->request('POST', sprintf('domain/%s/authcode/', $domain));
    }

    /**
     * Get domain operations history
     */
    public function getDomainHistory(string $domain): array
    {
        return $this->request('GET', sprintf('domain/%s/history/', $domain));
    }

    /**
     * Restore an expired domain
     */
    public function restoreDomain(string $domain): array
    {
        return $this->request('POST', sprintf('domain/%s/restore/', $domain));
    }
}
