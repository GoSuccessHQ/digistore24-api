# getServiceProofRequest

Retrieves detailed information about a specific service proof request.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getServiceProofRequest`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getServiceProofRequest.yaml)

## Parameters

The request takes a single scalar constructor argument:

- `serviceProofId` (int, required) — The numeric ID of the service proof request to retrieve.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ServiceProof\GetServiceProofRequestRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetServiceProofRequestRequest(serviceProofId: 12345);

$response = $ds24->serviceProofs->get($request);

echo $response->result; // e.g. "success"

// Typed properties
echo $response->id;          // 12345
echo $response->purchaseId;  // e.g. "ABC123"
echo $response->status;      // e.g. "pending"

// Or the typed DTO
echo $response->serviceProofRequest?->status ?? '';
```

## Response

`GetServiceProofRequestResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `id` (?int) — Service proof request ID.
- `purchaseId` (?string) — Associated purchase ID.
- `status` (?string) — Current status of the service proof request.
- `createdAt` (?DateTimeImmutable) — When the request was created.
- `dueDate` (?DateTimeImmutable) — When the proof needs to be provided by.
- `notes` (?string) — Additional notes about the request.
- `serviceProofRequest` (?ServiceProofRequestData) — The request as a typed DTO.
- `data` (array) — The complete `service_proof_request` payload.

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
