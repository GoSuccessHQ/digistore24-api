# unregister

Unregisters and revokes the current API access. The API key is no longer valid after this call.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/unregister`

[OpenAPI spec](https://digistore24.com/api/docs/paths/unregister.yaml)

## Parameters

`UnregisterRequest` takes no parameters. The request is optional; calling `$ds24->apiKeys->unregister()` with no arguments creates it for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ApiKey\UnregisterRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->apiKeys->unregister(new UnregisterRequest());

echo $response->result;                       // e.g. "success"
echo $response->modified ? 'revoked' : 'unchanged';
echo $response->note;                         // confirmation message
```

You can also omit the request entirely:

```php
$response = $ds24->apiKeys->unregister();
```

## Response

`UnregisterResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `modified` (bool) — Whether the API key was modified/deleted.
- `note` (string|null) — Confirmation message from the API.

## Error Handling

```php
try {
    $response = $ds24->apiKeys->unregister(new UnregisterRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [requestApiKey](requestApiKey.md)
- [retrieveApiKey](retrieveApiKey.md)
