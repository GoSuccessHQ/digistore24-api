# requestApiKey

Requests a new API key for the specified vendor email address. A verification token is sent to that email to confirm ownership.

## Endpoint

**POST** `https://www.digistore24.com/api/call/requestApiKey`

[OpenAPI spec](https://digistore24.com/api/docs/paths/requestApiKey.yaml)

## Parameters

`RequestApiKeyRequest` takes the following constructor argument:

- `email` (string, required) — The vendor email address that the verification token is sent to.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ApiKey\RequestApiKeyRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new RequestApiKeyRequest(email: 'vendor@example.com');

$response = $ds24->apiKeys->request($request);

echo $response->result;     // e.g. "success"
echo $response->apiKey;     // the generated API key
echo $response->createdAt?->format('Y-m-d H:i:s');
```

## Response

`RequestApiKeyResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `apiKey` (string) — The generated API key.
- `createdAt` (`DateTimeInterface`|null) — Creation timestamp.
- `description` (string|null) — API key description.
- `permissions` (string[]) — Granted permissions.
- `rateLimit` (int|null) — Rate limit for this API key.

## Error Handling

```php
try {
    $response = $ds24->apiKeys->request($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [retrieveApiKey](retrieveApiKey.md)
- [unregister](unregister.md)
