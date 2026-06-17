# ipnInfo

Retrieves IPN connection settings for the authenticated account.

## Endpoint

**GET** `https://www.digistore24.com/api/call/ipnInfo`

[OpenAPI spec](https://digistore24.com/api/docs/paths/ipnInfo.yaml)

## Parameters

The constructor argument is optional:

- `domainId` (string, optional) — Domain ID specified when creating the connection using `ipnSetup`. When omitted, the resource builds an empty `IpnInfoRequest` for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Ipn\IpnInfoRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// Without a specific domain
$response = $ds24->ipn->info();

// Or for a specific connection
$request = new IpnInfoRequest(domainId: 'my-platform');
$response = $ds24->ipn->info($request);

echo $response->result; // e.g. "success"
echo $response->url;    // e.g. "https://example.com/webhooks/digistore24"
```

## Response

`IpnInfoResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `url` (string|null) — The configured IPN URL.

## Error Handling

```php
try {
    $response = $ds24->ipn->info($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [ipnSetup](ipnSetup.md)
- [ipnDelete](ipnDelete.md)
