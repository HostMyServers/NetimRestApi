<?php

namespace HostMyServers\NetimRestApi\Services;

class DomainService extends BaseService
{
    /**
     * Récupère les informations d'un domaine spécifique.
     *
     * @param string $domain Nom du domaine à récupérer.
     * @return array Informations du domaine.
     * @throws NetimException Si une erreur survient lors de la requête.
     */
    public function getDomainInfo(string $domain): array
    {
        return $this->request('GET', 'domain/' . $domain);
    }

    /**
     * Crée un nouveau domaine.
     *
     * @param array $domainData Données du domaine à créer.
     * @return array Résultat de la création.
     * @throws NetimException Si une erreur survient lors de la requête.
     */
    public function createDomain(array $domainData): array
    {
        return $this->request('POST', 'domain', [
            'json' => $domainData,
        ]);
    }

}

