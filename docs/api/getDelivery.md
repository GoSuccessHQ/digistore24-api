# getDelivery

Retrieves delivery information for a specific delivery ID.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getDelivery`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getDelivery.yaml)

## Parameters

The request takes scalar constructor arguments:

- `deliveryId` (string, required) — The delivery ID to retrieve.
- `setInProgress` (bool, optional) — If `true`, marks the delivery as in progress if it is not already. Defaults to `false`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Delivery\GetDeliveryRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetDeliveryRequest(deliveryId: '3634', setInProgress: true);

$response = $ds24->deliveries->get($request);

echo $response->result; // e.g. "success"

$delivery = $response->delivery;
if ($delivery !== null) {
    echo $delivery->productName;          // e.g. "Premium Course"
    echo $delivery->purchaseId;           // e.g. "ABCD1234"
    echo $delivery->quantityDelivered;    // e.g. 1

    $address = $delivery->deliveryAddress;
    if ($address !== null) {
        echo $address->firstName . ' ' . $address->lastName;
    }

    foreach ($delivery->tracking as $tracking) {
        echo $tracking->trackingId;
    }
}

if ($response->isSetInProgress) {
    echo 'Delivery marked as in progress.';
} elseif ($response->setInProgressFailReason !== null) {
    echo $response->setInProgressFailReason;
}
```

## Response

`GetDeliveryResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `delivery` (`DeliveryDetailsData`|null) — The delivery details, or `null` when none are returned.
- `isSetInProgress` (bool) — Whether the delivery was marked as in progress.
- `setInProgressFailReason` (string|null) — Reason why setting in progress failed, if applicable.

The `DeliveryDetailsData` object exposes read-only properties including: `id` (int|null), `purchaseId` (string|null), `purchaseCreatedAt` (DateTimeImmutable|null), `purchaseItemId` (int|null), `buyerAddressId` (int|null), `type` (string|null), `processedAt` (DateTimeImmutable|null), `processedBy` (string|null), `productId` (int|null), `productName` (string|null), `productTypeId` (int|null), `productTypeName` (string|null), `variantLabel` (string|null), `variantName` (string|null), `variantKey` (string|null), `variantId` (int|null), `quantityDelivered` (int|null), `quantityTotal` (int|null), `isShippmentByResellerId` (string|null), `isTestOrder` (bool), `deliveryType` (string|null), `invoiceUrl` (string|null), `deliverySlipUrl` (string|null), `deliveryAddress` (`DeliveryAddressData`|null), and `tracking` (array of `DeliveryTrackingData`).

## Error Handling

```php
try {
    $response = $ds24->deliveries->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listDeliveries](listDeliveries.md)
- [updateDelivery](updateDelivery.md)
