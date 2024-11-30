<?php

namespace HostMyServers\NetimRestApi\Services;

/**
 * Service pour gérer les contacts via l'API Netim.
 */
class ContactService extends BaseService
{
    /**
     * Crée un nouveau contact
     *
     * @param array $contactData Les données du contact à créer
     * @return object La réponse de l'API contenant l'ID du contact
     */
    public function createContact(array $contactData): object
    {
        return $this->request('POST', 'contact/', [
            'json' => [
                'contact' => $contactData
            ]
        ]);
    }

    /**
     * Récupère les informations d'un contact
     *
     * @param string $contactId L'ID du contact
     * @return object Les informations du contact
     */
    public function getContact(string $contactId): object
    {
        return $this->request('GET', "contact/{$contactId}/");
    }

    /**
     * Met à jour un contact existant
     *
     * @param string $contactId L'ID du contact
     * @param array $contactData Les nouvelles données du contact
     * @return object La réponse de l'API
     */
    public function updateContact(string $contactId, array $contactData): object
    {
        return $this->request('PATCH', "contact/{$contactId}/", [
            'json' => [
                'contact' => $contactData
            ]
        ]);
    }

    /**
     * Supprime un contact
     *
     * @param string $contactId L'ID du contact à supprimer
     * @return object La réponse de l'API
     */
    public function deleteContact(string $contactId): object
    {
        return $this->request('DELETE', "contact/{$contactId}/");
    }

    /**
     * Récupère la liste des contacts filtrée
     *
     * @param string $field Champ sur lequel appliquer le filtre (id, firstName, lastName, bodyForm, isOwner)
     * @param string $filter Filtre à appliquer (peut utiliser * comme joker)
     * @return array Liste des contacts correspondant au filtre
     */
    public function getContactList(string $field, string $filter): array
    {
        return $this->request('GET', "contacts/{$field}/{$filter}/", [], true);
    }
}
