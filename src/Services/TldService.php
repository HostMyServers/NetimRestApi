<?php

namespace HostMyServers\NetimRestApi\Services;

class TldService extends BaseService
{
    /**
     * Get TLD information
     */
    public function getInfo(string $tld): object
    {
        return $this->request('GET', sprintf('tld/%s/', $tld));
    }

    /**
     * Get TLDs list
     */
    public function getPriceList(): object
    {
        return $this->request('GET', 'tlds/price-list/');
    }
}
