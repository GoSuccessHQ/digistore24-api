# updateDelivery

Updates a delivery record with a new status, tracking information, and other details.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateDelivery`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateDelivery.yaml)

## Parameters

The request takes the delivery ID, a `DeliveryData` DTO, an optional list of tracking entries, and a notification flag:

- `deliveryId` (string, required) — The ID of the delivery to update.
- `delivery` (`DeliveryData`, required) — Delivery status data (sent as the `data` object). Populate the following settable properties:
  - `type` (`DeliveryStatus`|null, optional) — The delivery status type. Values: `REQUEST`, `IN_PROGRESS`, `DELIVERY`, `PARTIAL_DELIVERY`, `RETURN`, `CANCEL`.
  - `isShipped` (bool|null, optional) — `true` marks the product as shipped (`type` = delivery); `false` cancels the delivery (`type` = cancel).
  - `quantityDelivered` (int|null, optional) — Sets the delivery quantity to this value. Must not be negative.
  - `addQuantityDelivered` (int|null, optional) — Adds this value to the delivery quantity. Must not be negative.
  - `isShippedByResellerFrom` (string|null, optional) — Fulfillment center code, if applicable.
- `tracking` (list of `DeliveryTrackingUpdateData`, optional) — Tracking entries to create, update, or delete. Defaults to an empty array.
- `notifyViaEmail` (bool, optional) — Whether to notify the buyer about the delivery update. Defaults to `true`.

Each `DeliveryTrackingUpdateData` entry has these constructor arguments:

- `parcelService` (string|null, optional) — The parcel service key (see https://www.digistore24.com/support/parcel_services).
- `trackingId` (string|null, optional) — The tracking ID for the shipment.
- `expectDeliveryAt` (DateTimeInterface|null, optional) — Expected delivery date (sent as `YYYY-MM-DD`).
- `quantity` (int|null, optional) — Quantity of items in this tracking entry (defaults to all items).
- `operation` (`DeliveryTrackingOperation`, optional) — Operation to perform. Defaults to `DeliveryTrackingOperation::CREATE_OR_UPDATE`. Other value: `DELETE`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Delivery\UpdateDeliveryRequest;
use GoSuccess\Digistore24\Api\DTO\DeliveryData;
use GoSuccess\Digistore24\Api\DTO\DeliveryTrackingUpdateData;
use GoSuccess\Digistore24\Api\Enum\DeliveryStatus;
use GoSuccess\Digistore24\Api\Enum\DeliveryTrackingOperation;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$delivery = new DeliveryData();
$delivery->type = DeliveryStatus::DELIVERY;
$delivery->isShipped = true;
$delivery->quantityDelivered = 1;

$tracking = new DeliveryTrackingUpdateData(
    parcelService: 'dhl',
    trackingId: 'TRACK123456',
    expectDeliveryAt: new DateTimeImmutable('2026-06-20'),
    quantity: 1,
    operation: DeliveryTrackingOperation::CREATE_OR_UPDATE,
);

$request = new UpdateDeliveryRequest(
    deliveryId: '3634',
    delivery: $delivery,
    tracking: [$tracking],
    notifyViaEmail: true,
);

$response = $ds24->deliveries->update($request);

echo $response->result; // e.g. "success"
```

## Response

`UpdateDeliveryResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `isModified` (?bool) — Whether the delivery was modified.

## Error Handling

```php
try {
    $response = $ds24->deliveries->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getDelivery](getDelivery.md)
- [listDeliveries](listDeliveries.md)
