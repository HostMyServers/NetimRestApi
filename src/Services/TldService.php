<?php

namespace HostMyServers\NetimRestApi\Services;

/**
 * Service pour gérer les hébergements web via l'API Netim.
 */
class TldService extends BaseService
{
    /**
     * Get TLD information
     */
    public function getInfo(string $tld): object
    {
        return $this->request('GET', sprintf('tld/%s/', $tld));
    }
}
