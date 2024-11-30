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

// Check multiple domains
$domains = ['example.com', 'example.net', 'example.org'];
$multipleCheck = $netim->domain->checkMultipleDomains($domains);

// Register a new domain
$domainData = [
    'duration' => 1,
    'contacts' => [
        'owner' => [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@example.com',
            // ... other contact details
        ]
    ]
];
$registration = $netim->domain->createDomain($domainData);

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

### Domain Management
- `checkDomain(string $domain)`: Check domain availability
- `checkMultipleDomains(array $domains)`: Check multiple domains availability
- `createDomain(array $domainData)`: Register a new domain
- `getDomainInfo(string $domain)`: Get domain information
- `transferDomain(string $domain, array $transferData)`: Transfer a domain
- `renewDomain(string $domain, array $renewData)`: Renew a domain
- `deleteDomain(string $domain)`: Delete a domain
- `getDomainsList()`: Get list of all domains

### DNS Management
- `updateDNS(string $domain, array $nameservers)`: Update domain nameservers
- `getDNS(string $domain)`: Get domain nameservers
- `setDNSSEC(string $domain, array $dnssecData)`: Configure DNSSEC
- `getDNSSEC(string $domain)`: Get DNSSEC configuration

### Domain Settings
- `setWhoisPrivacy(string $domain, bool $enabled)`: Enable/Disable WHOIS privacy
- `getWhoisPrivacy(string $domain)`: Get WHOIS privacy status
- `setAutoRenew(string $domain, bool $enabled)`: Enable/Disable auto-renewal
- `getAutoRenew(string $domain)`: Get auto-renewal status
- `setDomainLock(string $domain, bool $locked)`: Update domain lock status
- `getDomainLock(string $domain)`: Get domain lock status

### Contact Management
- `updateContacts(string $domain, array $contacts)`: Update domain contacts
- `getContacts(string $domain)`: Get domain contacts

### Other Operations
- `getWhois(string $domain)`: Get domain WHOIS information
- `requestAuthCode(string $domain)`: Request auth code for domain transfer
- `getDomainHistory(string $domain)`: Get domain operations history
- `restoreDomain(string $domain)`: Restore an expired domain

## License

This package is open-sourced software licensed under the MIT license.


