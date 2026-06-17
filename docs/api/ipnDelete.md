# ipnDelete

Deletes an IPN connection identified by its domain ID.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/ipnDelete`

[OpenAPI spec](https://digistore24.com/api/docs/paths/ipnDelete.yaml)

## Parameters

The `delete()` method accepts the domain ID directly as a string (it builds the `IpnDeleteRequest` for you):

- `domainId` (string, required) — The domain ID that identifies which IPN connection to delete. This is the value supplied as `domainId` during `ipnSetup`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->ipn->delete('my-platform');

echo $response->result; // e.g. "success"
```

## Response

`IpnDeleteResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.

## Error Handling

```php
try {
    $response = $ds24->ipn->delete('my-platform');
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [ipnSetup](ipnSetup.md)
- [ipnInfo](ipnInfo.md)
