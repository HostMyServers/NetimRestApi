<?php

namespace HostMyServers\NetimRestApi\Services;

/**
 * Service pour gérer les requests liées aux TLD/gTLD.
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
