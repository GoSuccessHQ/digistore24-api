# retrieveApiKey

Retrieves the API key using the vendor email and the verification token received by email.

## Endpoint

**POST** `https://www.digistore24.com/api/call/retrieveApiKey`

[OpenAPI spec](https://digistore24.com/api/docs/paths/retrieveApiKey.yaml)

## Parameters

`RetrieveApiKeyRequest` takes the following constructor arguments:

- `email` (string, required) — The vendor email address.
- `token` (string, required) — The verification token received via email.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ApiKey\RetrieveApiKeyRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new RetrieveApiKeyRequest(
    email: 'vendor@example.com',
    token: 'verification-token-from-email',
);

$response = $ds24->apiKeys->retrieve($request);

echo $response->result;       // e.g. "success"
echo $response->apiKeyId;     // the API key ID
echo $response->isActive ? 'active' : 'inactive';
echo $response->requestsToday . '/' . $response->rateLimit;
```

## Response

`RetrieveApiKeyResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `apiKeyId` (string) — The API key ID.
- `description` (string|null) — API key description.
- `createdAt` (`DateTimeInterface`|null) — Creation timestamp.
- `lastUsedAt` (`DateTimeInterface`|null) — Last usage timestamp.
- `isActive` (bool) — Whether the API key is active.
- `permissions` (string[]) — Granted permissions.
- `rateLimit` (int|null) — Rate limit for this API key.
- `requestsToday` (int|null) — Number of requests made today.

## Error Handling

```php
try {
    $response = $ds24->apiKeys->retrieve($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [requestApiKey](requestApiKey.md)
- [unregister](unregister.md)
