# HostMyServers Netim REST API Client

A Laravel package to interact with the Netim API for domain management.

## Installation

You can install the package via composer:

```bash
composer require hostmyservers/netim-rest-api
```

## Configuration

First, publish the configuration file using the following command:

```bash
php artisan vendor:publish --provider="HostMyServers\NetimRestApi\NetimServiceProvider"
```

This will create a `config/netim.php` file in your project.

Add these variables to your `.env` file:

```env
NETIM_LOGIN=your_login
NETIM_SECRET=your_secret
NETIM_LANGUAGE=EN
NETIM_API_URL=https://api.netim.com/v1/
```

The published configuration file will automatically use these environment variables.

## Basic Usage

```php
use HostMyServers\NetimRestApi\NetimClient;

// Initialize the client
$netim = new NetimClient();

// Check domain availability
$availability = $netim->domain->checkDomain('example.com');

// Get domain information
$domainInfo = $netim->domain->getDomainInfo('example.com');

// Update DNS servers
$nameservers = [
    'ns1.example.com',
    'ns2.example.com'
];
$dnsUpdate = $netim->domain->updateDNS('example.com', $nameservers);

// Enable WHOIS privacy
$privacy = $netim->domain->setWhoisPrivacy('example.com', true);

// Get list of all domains
$allDomains = $netim->domain->getDomainsList();
```

## Error Handling

The API client throws `NetimException` when errors occur. You should handle these exceptions in your code:

```php
use HostMyServers\NetimRestApi\Exceptions\NetimException;

try {
    $domainInfo = $netim->domain->getDomainInfo('example.com');
} catch (NetimException $e) {
    echo "Error: " . $e->getMessage();
    echo "API Error Code: " . $e->getApiErrorCode();
    echo "API Error Data: " . print_r($e->getApiErrorData(), true);
}
```

## Session Management

The client automatically handles session creation and cleanup. However, you can manually manage sessions if needed:

```php
// Check if session is active
if ($netim->hasActiveSession()) {
    // Do something
}

// Force session renewal
$netim->renewSession();

// Manually close session
$netim->closeSession();
```

## Available Methods

### Domain Management (DomainService)
- `getDomainInfo(string $domain)`: Get domain information
- `checkDomain(string $domain)`: Check domain availability
- `checkDomainClaim(string $domain)`: Check domain claims
- `createDomain(string $domain, array $domainData)`: Register a new domain
- `transferDomain(string $domain, array $transferData)`: Transfer a domain to Netim
- `transferDomainTrade(string $domain, array $transferData)`: Transfer and trade a domain
- `renewDomain(string $domain, int $period)`: Renew a domain
- `updateDNS(string $domain, array $nameservers)`: Update DNS servers
- `setWhoisPrivacy(string $domain, bool $enabled)`: Enable/Disable WHOIS privacy
- `setAutoRenew(string $domain, bool $enabled)`: Enable/Disable auto-renewal
- `getWhois(string $domain)`: Get WHOIS information
- `deleteDomain(string $domain)`: Delete a domain
- `getDomainsList()`: Get list of all domains
- `setDNSSEC(string $domain, int $enabled)`: Configure DNSSEC
- `setDNSSECExt(string $domain, array $dnssecData)`: Configure external DNSSEC
- `setDomainLock(string $domain, string $locked)`: Update domain lock status
- `requestAuthCode(string $domain, int $sendtoregistrant)`: Request authorization code
- `restoreDomain(string $domain)`: Restore an expired domain

### Zones Management (ZonesService)
- `initializeDnsZone(string $domain, array $options)`: Initialize a DNS zone
- `initializeSoaRecord(string $domain, array $options)`: Initialize SOA record
- `createDnsZone(string $domain, array $records)`: Create a DNS zone
- `deleteDnsZone(string $domain, $records)`: Delete a DNS zone
- `getDnsRecordsList(string $domain)`: Get list of DNS records
- `createMailForward(string $domain, string $source, string $destination)`: Create an email forward
- `deleteMailForward(string $domain, string $source)`: Delete an email forward
- `getMailForwardsList(string $domain)`: Get list of email forwards
- `createWebForward(string $domain, string $source, string $destination, array $options)`: Create a web forward
- `deleteWebForward(string $domain, string $source)`: Delete a web forward
- `getWebForwardsList(string $domain)`: Get list of web forwards

### Contact Management (ContactService)
- `createContact(array $contactData)`: Create a new contact
- `getContact(string $contactId)`: Get contact information
- `updateContact(string $contactId, array $contactData)`: Update a contact
- `deleteContact(string $contactId)`: Delete a contact
- `getContactList(string $field, string $filter)`: Get filtered list of contacts

### TLD Services (TldService)
- `getInfo(string $tld)`: Get TLD information
- `getPriceList()`: Get TLD price list

### Web Hosting (WebHostingService)
- `getHostingInfo(string $hostingId)`: Get web hosting information
- `createHosting(array $hostingData)`: Create a new web hosting

## License

This package is open-sourced software licensed under the MIT license.


