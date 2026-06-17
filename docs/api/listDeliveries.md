# listDeliveries

Retrieves a list of deliveries, optionally filtered by a search object.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listDeliveries`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listDeliveries.yaml)

## Parameters

The constructor argument is optional:

- `search` (`DeliverySearchData`, optional) — Search criteria. Settable properties:
  - `purchaseId` (?string) — Filter by order/purchase ID.
  - `from` (?DateTimeInterface) — Start date for filtering.
  - `to` (?DateTimeInterface) — End date for filtering.
  - `type` (?string) — Comma-separated list of delivery types (`request`, `in_progress`, `delivery`, `partial_delivery`, `return`, `cancel`).
  - `sameAddressAs` (?string) — Lists all deliveries shipped to the same address as the given delivery ID.
  - `isProcessed` (?bool) — Filter by processed status.
  - `isTestOrder` (?bool) — Filter test vs real orders.

When omitted, the resource builds an empty `ListDeliveriesRequest` for you and all deliveries are returned.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\DTO\DeliverySearchData;
use GoSuccess\Digistore24\Api\Request\Delivery\ListDeliveriesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// All deliveries
$response = $ds24->deliveries->list();

// Or filtered
$request = new ListDeliveriesRequest(
    new DeliverySearchData(purchaseId: 'ABCD1234', type: 'delivery,partial_delivery'),
);
$response = $ds24->deliveries->list($request);

echo $response->result; // e.g. "success"

foreach ($response->deliveries as $delivery) {
    // each $delivery is a DeliveryDetailsData DTO
    echo $delivery->id, ' ', $delivery->purchaseId, PHP_EOL;
}
```

## Response

`ListDeliveriesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `deliveries` (`DeliveryDetailsData[]`) — The list of deliveries, each a typed DTO (including address and tracking).

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
