# getServiceProofRequest

Retrieves detailed information about a specific service proof request.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getServiceProofRequest`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getServiceProofRequest.yaml)

## Parameters

The request takes a single scalar constructor argument:

- `serviceProofRequestId` (string, required) — The unique identifier of the service proof request to retrieve.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ServiceProof\GetServiceProofRequestRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetServiceProofRequestRequest(serviceProofRequestId: 'SPR-12345');

$response = $ds24->serviceProofs->get($request);

echo $response->result; // e.g. "success"

// Inspect the request details
$proof = $response->serviceProofRequest;
echo $proof['request_status'] ?? '';
```

## Response

`GetServiceProofRequestResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `serviceProofRequest` (array) — The service proof request details. Read as `$response->serviceProofRequest['key']`.

## Error Handling

```php
try {
    $response = $ds24->serviceProofs->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listServiceProofRequests](listServiceProofRequests.md)
- [updateServiceProofRequest](updateServiceProofRequest.md)
