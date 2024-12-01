<?php

namespace HostMyServers\NetimRestApi\Services;

class ContactService extends BaseService
{
    /**
     * Creates a new contact
     *
     * @param array $contactData Contact data to create
     * @return object API response containing the contact ID
     */
    public function createContact(array $contactData): object|string
    {
        return $this->request('POST', 'contact/', [
            'json' => [
                'contact' => $contactData
            ]
        ]);
    }

    /**
     * Retrieves contact information
     *
     * @param string $contactId Contact ID
     * @return object Contact information
     */
    public function getContact(string $contactId): object
    {
        return $this->request('GET', "contact/{$contactId}/");
    }

    /**
     * Updates an existing contact
     *
     * @param string $contactId Contact ID
     * @param array $contactData New contact data
     * @return object API response
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
     * Deletes a contact
     *
     * @param string $contactId ID of the contact to delete
     * @return object API response
     */
    public function deleteContact(string $contactId): object
    {
        return $this->request('DELETE', "contact/{$contactId}/");
    }

    /**
     * Retrieves filtered list of contacts
     *
     * @param string $field Field to apply the filter on (id, firstName, lastName, bodyForm, isOwner)
     * @param string $filter Filter to apply (can use * as wildcard)
     * @return array List of contacts matching the filter
     */
    public function getContactList(string $field, string $filter): array
    {
        return $this->request('GET', "contacts/{$field}/{$filter}/", [], true);
    }
}
