# listServiceProofRequests

Retrieves a list of service proof requests, optionally filtered by a search object.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listServiceProofRequests`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listServiceProofRequests.yaml)

## Parameters

The constructor argument is optional:

- `search` (`ServiceProofRequestSearchData`, optional) — Search criteria. Settable properties:
  - `purchaseId` (?string) — Filter by purchase ID.
  - `productId` (?int) — Filter by product ID.
  - `deliveryType` (?`DeliveryType`) — Filter by delivery type.
  - `approvalStatus` (?`ServiceProofApprovalStatus`) — Filter by approval status (`new`, `pending`, `approved`, `rejected`).
  - `requestStatus` (?`ServiceProofRequestStatus`) — Filter by request status (`pending`, `proof_provided`, `exec_refund`).

When called without a request, the resource builds an empty `ListServiceProofRequestsRequest` for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestSearchData;
use GoSuccess\Digistore24\Api\Enum\ServiceProofRequestStatus;
use GoSuccess\Digistore24\Api\Request\ServiceProof\ListServiceProofRequestsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// List all
$response = $ds24->serviceProofs->list();

// Or filtered
$request = new ListServiceProofRequestsRequest(
    new ServiceProofRequestSearchData(
        purchaseId: 'ABC123',
        requestStatus: ServiceProofRequestStatus::PENDING,
    ),
);
$response = $ds24->serviceProofs->list($request);

echo $response->result; // e.g. "success"

foreach ($response->serviceProofRequests as $proof) {
    // each $proof is a ServiceProofRequestData DTO
    echo $proof->id, ' ', $proof->requestStatus, PHP_EOL;
}
```

## Response

`ListServiceProofRequestsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `serviceProofRequests` (`ServiceProofRequestData[]`) — The list of service proof requests, each a typed DTO.

## Error Handling

```php
try {
    $response = $ds24->serviceProofs->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getServiceProofRequest](getServiceProofRequest.md)
- [updateServiceProofRequest](updateServiceProofRequest.md)
