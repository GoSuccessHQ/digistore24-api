# createAddonChangePurchase

Creates a package change order that adds products to an existing order. Added products must be subscriptions; the main product's quantity cannot be changed.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createAddonChangePurchase`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createAddonChangePurchase.yaml)

Requirements:
- The "Billing on demand" right must be enabled for the vendor account.
- The reference order must use a payment method that supports rebilling.

## Parameters

Constructor arguments of `CreateAddonChangePurchaseRequest`:

- `purchaseId` (string, required) — The reference order ID. Must support rebilling.
- `addons` (array of `AddonData`, required) — One or more add-on products. At least one is required.
- `tracking` (`TrackingData`, optional) — Tracking data. Fields not provided are taken from the initial purchase.
- `placeholders` (`PlaceholderData`, optional) — Placeholders for the product title and description.

Each `AddonData` exposes the following settable properties:

- `productId` (int, required) — Digistore24 product ID.
- `amount` (float, optional) — The rebilling amount of the subscription. Must be >= 0.
- `quantity` (int, optional) — Quantity of the add-on. Minimum 1. Defaults to `1`.
- `isQuantityEditableAfterPurchase` (bool, optional) — Whether the buyer may change the quantity after purchase. Defaults to `false`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\CreateAddonChangePurchaseRequest;
use GoSuccess\Digistore24\Api\DTO\AddonData;
use GoSuccess\Digistore24\Api\DTO\TrackingData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$addon = new AddonData();
$addon->productId = 987654;
$addon->amount = 19.0;
$addon->quantity = 1;

$tracking = new TrackingData();
$tracking->custom = 'addon-upsell-2026';

$request = new CreateAddonChangePurchaseRequest(
    purchaseId: '12345678',
    addons: [$addon],
    tracking: $tracking,
);

$response = $ds24->purchases->createAddonChange($request);

echo $response->createdPurchaseId; // e.g. "23456789"
echo $response->billingStatusMsg;  // e.g. "Order completed."

if ($response->payUrl !== null) {
    echo $response->payUrl; // present if the payment must be restarted
}
```

## Response

`CreateAddonChangePurchaseResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `createdPurchaseId` (string) — ID of the new order.
- `paymentStatus` (string) — Payment status code.
- `paymentStatusMsg` (string) — Payment status in human-readable form.
- `billingStatus` (string) — Status of the new order.
- `billingStatusMsg` (string) — Order status in human-readable form.
- `payUrl` (string|null) — URL to restart payments if the payment failed; `null` otherwise.

## Error Handling

```php
try {
    $response = $ds24->purchases->createAddonChange($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createUpgradePurchase](createUpgradePurchase.md)
- [createBillingOnDemand](createBillingOnDemand.md)
- [getPurchase](getPurchase.md)
- [listPurchases](listPurchases.md)
