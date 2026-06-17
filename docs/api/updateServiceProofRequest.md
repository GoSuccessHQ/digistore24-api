# updateServiceProofRequest

Updates an existing service proof request, either providing proof or executing a refund.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateServiceProofRequest`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateServiceProofRequest.yaml)

## Parameters

The request takes the service proof request ID plus a `ServiceProofRequestUpdateData` DTO:

- `serviceProofId` (int, required) — The numeric ID of the service proof request.
- `proofData` (`ServiceProofRequestUpdateData`, required) — The update payload. Populate the following settable properties:
  - `requestStatus` (string, required) — Either `proof_provided` or `exec_refund`. Any other value throws an `InvalidArgumentException`.
  - `message` (string, optional) — Additional explanation about the proof or refund decision.
  - `files` (array of `FileData`, optional) — Files that serve as proof of service delivery.

Each `FileData` entry has these settable properties:

- `url` (string, required) — Download URL for the file contents. Must be a valid URL.
- `filename` (string, optional) — A filename for the file.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ServiceProof\UpdateServiceProofRequestRequest;
use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestUpdateData;
use GoSuccess\Digistore24\Api\DTO\FileData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$file = new FileData();
$file->url = 'https://example.com/proofs/service-proof.pdf';
$file->filename = 'service-proof.pdf';

$proofData = new ServiceProofRequestUpdateData();
$proofData->requestStatus = 'proof_provided';
$proofData->message = 'Coaching session delivered on 2026-06-10.';
$proofData->files = [$file];

$request = new UpdateServiceProofRequestRequest(
    serviceProofId: 12345,
    proofData: $proofData,
);

$response = $ds24->serviceProofs->update($request);

echo $response->result; // e.g. "success"
var_dump($response->isModified); // true when the request was modified
```

## Response

`UpdateServiceProofRequestResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `isModified` (?bool) — Whether the service proof request was modified.

## Error Handling

```php
try {
    $response = $ds24->serviceProofs->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getServiceProofRequest](getServiceProofRequest.md)
- [listServiceProofRequests](listServiceProofRequests.md)
