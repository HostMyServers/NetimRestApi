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
        return $this->request('GET', sprintf('domain/%s/check/', $domain))[0];
    }

    /**
     * Check domain Claim
     */
    public function checkDomainClaim(string $domain): object
    {
        return $this->request('GET', sprintf('domain/%s/claim/', $domain));
    }

    /**
     * Register a new domain
     */
    public function createDomain(string $domain, array $domainData): object
    {
        return $this->request('POST', sprintf('domain/%s/', $domain), [
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
     * Transfer and Trade a domain to Netim
     */
    public function transferDomainTrade(string $domain, array $transferData): object
    {
        return $this->request('POST', sprintf('domain/%s/transfer-trade/', $domain), [
            'json' => $transferData
        ]);
    }

    /**
     * Transfer a domain to another Netim account (internal transfer)
     */
    public function internalTransferDomain(string $domain, array $transferData): object
    {
        return $this->request('POST', sprintf('domain/%s/internal-transfer/', $domain), [
            'json' => $transferData
        ]);
    }

    /**
     * Change the owner (holder) of a domain. The new owner must be a contact with isOwner=1.
     */
    public function transferOwner(string $domain, string $idOwner): object
    {
        return $this->request('PUT', sprintf('domain/%s/transfer-owner/', $domain), [
            'json' => [
                'idOwner' => $idOwner
            ]
        ]);
    }

    /**
     * Renew a domain
     */
    public function renewDomain(string $domain, int $period): object
    {
        return $this->request('PATCH', sprintf('domain/%s/renew/', $domain), [
            'json' => [
                'duration' => $period
            ]
        ]);
    }

    /**
     * Update domain DNS servers
     */
    public function updateDNS(string $domain, array $nameservers): object
    {
        return $this->request('PUT', sprintf('domain/%s/dns/', $domain), [
            'json' => $nameservers
        ]);
    }

    /**
     * Enable/Disable WHOIS privacy
     */
    public function setWhoisPrivacy(string $domain, bool $enabled): object
    {
        return $this->request('PATCH', sprintf('domain/%s/preference/', $domain), [
            'json' => [
                'codePref' => 'whois_privacy',
                'value' => $enabled
            ]
        ]);
    }

    /**
     * Enable/Disable auto-renewal
     */
    public function setAutoRenew(string $domain, bool $enabled): object
    {
        return $this->request('PATCH', sprintf('domain/%s/preference/', $domain), [
            'json' => [
                'codePref' => 'auto_renew',
                'value' => $enabled
            ]
        ]);
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
     * Get list of domains matching a filter
     *
     * Use * as wildcard (e.g. "*" for the whole portfolio or "*.eu").
     *
     * @return list<array{domain: string, dateCreate: string, dateExpiration: string}>
     */
    public function getDomainsList(string $filter = '*'): array
    {
        return $this->request('GET', sprintf('domains/%s', $filter), [], true);
    }

    /**
     * Configure DNSSEC for a domain
     */
    public function setDNSSEC(string $domain, int $enabled): object
    {
        return $this->request('PATCH', sprintf('domain/%s/dnssec/', $domain), [
            'json' => [
                'enable' => $enabled
            ]
        ]);
    }

    /**
     * Configure DNSSEC External for a domain
     */
    public function setDNSSECExt(string $domain, array $dnssecData): object
    {
        return $this->request('PATCH', sprintf('domain/%s/dnssec/', $domain), [
            'json' => $dnssecData
        ]);
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
        return $this->request('PATCH', sprintf('domain/%s/restore/', $domain));
    }
}
