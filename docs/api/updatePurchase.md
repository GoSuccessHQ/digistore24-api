# updatePurchase

Changes the tracking data of an order and can extend rebilling intervals.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updatePurchase`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updatePurchase.yaml)

## Parameters

Constructor arguments of `UpdatePurchaseRequest`:

- `purchaseId` (string, required) — The ID of the purchase to update.
- `trackingParam` (string, optional) — The vendor's tracking key.
- `custom` (string, optional) — The custom field.
- `unlockInvoices` (bool, optional) — Grant the buyer access to order details and invoices.
- `nextPaymentAt` (string, optional) — Extend the rebilling payment interval (date-time format). Intervals can only be extended, not shortened.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\UpdatePurchaseRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new UpdatePurchaseRequest(
    purchaseId: '12345678',
    trackingParam: 'campaign-2026',
    custom: 'customer-reference-456',
    unlockInvoices: true,
);

$response = $ds24->purchases->update($request);

if ($response->wasModified()) {
    echo 'Purchase updated.';
} else {
    echo 'No changes were made.';
}
```

To grant a payment pause, extend the next payment date:

```php
$request = new UpdatePurchaseRequest(
    purchaseId: '12345678',
    nextPaymentAt: '2026-09-01 00:00:00',
);
```

## Response

`UpdatePurchaseResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `isModified` (string) — `Y` if the purchase was modified, `N` otherwise.

Helper method:

- `wasModified(): bool` — Returns `true` when `isModified` equals `Y`.

## Error Handling

```php
try {
    $response = $ds24->purchases->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchase](getPurchase.md)
- [refundPurchase](refundPurchase.md)
- [addBalanceToPurchase](addBalanceToPurchase.md)
- [resendPurchaseConfirmationMail](resendPurchaseConfirmationMail.md)
