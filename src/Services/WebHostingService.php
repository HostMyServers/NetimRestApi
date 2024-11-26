<?php

namespace HostMyServers\NetimRestApi\Services;

/**
 * Service pour gérer les hébergements web via l'API Netim.
 */
class WebHostingService extends BaseService
{
    /**
     * Récupère les informations d'un hébergement web spécifique.
     *
     * @param string $hostingId ID de l'hébergement à récupérer.
     * @return array Informations de l'hébergement.
     * @throws NetimException Si une erreur survient lors de la requête.
     */
    public function getHostingInfo(string $hostingId): array
    {
        return $this->request('GET', 'hosting/' . $hostingId);
    }

    /**
     * Crée un nouvel hébergement web.
     *
     * @param array $hostingData Données de l'hébergement à créer.
     * @return array Résultat de la création.
     * @throws NetimException Si une erreur survient lors de la requête.
     */
    public function createHosting(array $hostingData): array
    {
        return $this->request('POST', 'hosting', [
            'json' => $hostingData,
        ]);
    }

    // Ajoutez d'autres méthodes liées à l'hébergement web ici...
}

