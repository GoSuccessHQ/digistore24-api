# listDeliveries

Retrieves a list of deliveries, optionally filtered by purchase ID.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listDeliveries`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listDeliveries.yaml)

## Parameters

The constructor argument is optional:

- `purchaseId` (string, optional) — Purchase ID to filter deliveries by. When omitted, the resource builds an empty `ListDeliveriesRequest` for you and all deliveries are returned.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Delivery\ListDeliveriesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// All deliveries
$response = $ds24->deliveries->list();

// Or filtered by purchase
$request = new ListDeliveriesRequest(purchaseId: 'ABCD1234');
$response = $ds24->deliveries->list($request);

echo $response->result; // e.g. "success"

foreach ($response->deliveries as $delivery) {
    // each $delivery is an associative array of delivery fields
}
```

## Response

`ListDeliveriesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `deliveries` (array) — The list of deliveries. Read as `$response->deliveries`.

## Error Handling

```php
try {
    $response = $ds24->deliveries->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getDelivery](getDelivery.md)
- [updateDelivery](updateDelivery.md)
