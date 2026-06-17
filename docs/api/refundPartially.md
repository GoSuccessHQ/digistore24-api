# refundPartially

Refunds a partial amount of a payment. The refund is treated as a discount and the order status does not change.

## Endpoint

**POST** `https://www.digistore24.com/api/call/refundPartially`

[OpenAPI spec](https://digistore24.com/api/docs/paths/refundPartially.yaml)

For a full refund that cancels the order, use [refundPurchase](refundPurchase.md) instead.

## Parameters

Constructor arguments of `RefundPartiallyRequest`:

- `purchaseId` (string, required) — The Digistore24 order ID.
- `amount` (float, required) — The amount to refund. Must not exceed the payment amount.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\RefundPartiallyRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new RefundPartiallyRequest(
    purchaseId: '12345678',
    amount: 15.0,
);

$response = $ds24->purchases->refundPartially($request);

if ($response->wasSuccessful()) {
    echo 'Partial refund processed.';
}
```

## Response

`RefundPartiallyResponse` exposes:

- `result` (string) — Result status returned by the API.

Helper method:

- `wasSuccessful(): bool` — Returns `true` when `result` equals `success`.

## Error Handling

```php
try {
    $response = $ds24->purchases->refundPartially($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [refundPurchase](refundPurchase.md)
- [getPurchase](getPurchase.md)
- [updatePurchase](updatePurchase.md)
- [createBillingOnDemand](createBillingOnDemand.md)
