# listServiceProofRequests

Retrieves a paginated list of service proof requests.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listServiceProofRequests`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listServiceProofRequests.yaml)

## Parameters

All constructor arguments are optional:

- `limit` (int, optional) — Maximum number of results to return.
- `offset` (int, optional) — Number of results to skip for pagination.

When called without a request, the resource builds an empty `ListServiceProofRequestsRequest` for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ServiceProof\ListServiceProofRequestsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// List with default paging
$response = $ds24->serviceProofs->list();

// Or with explicit pagination
$request = new ListServiceProofRequestsRequest(limit: 50, offset: 0);
$response = $ds24->serviceProofs->list($request);

echo $response->result; // e.g. "success"

foreach ($response->serviceProofRequests as $proof) {
    // each $proof is an associative array of request fields
}
```

## Response

`ListServiceProofRequestsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `serviceProofRequests` (array) — The list of service proof requests. Read as `$response->serviceProofRequests`.

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
