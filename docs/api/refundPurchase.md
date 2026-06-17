# refundPurchase

Refunds all payments of an order that may be refunded according to the refund policy.

## Endpoint

**POST** `https://www.digistore24.com/api/call/refundPurchase`

[OpenAPI spec](https://digistore24.com/api/docs/paths/refundPurchase.yaml)

For a partial refund that keeps the order active, use [refundPartially](refundPartially.md) instead.

## Parameters

Constructor arguments of `RefundPurchaseRequest`:

- `purchaseId` (string, required) — The Digistore24 order ID.
- `force` (bool, optional) — If `false` (default), refund only if the policy allows it. If `true`, attempt the refund anyway.
- `requestDate` (string, optional) — Apply refund policies based on this date. Defaults to `now` when omitted.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\RefundPurchaseRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new RefundPurchaseRequest(
    purchaseId: '12345678',
    force: false,
);

$response = $ds24->purchases->refund($request);

if ($response->wasSuccessful()) {
    echo 'Refund processed.';
}
```

## Response

`RefundPurchaseResponse` exposes:

- `result` (string) — Result status returned by the API.
- `data` (array) — Additional response data, if any.

Helper method:

- `wasSuccessful(): bool` — Returns `true` when `result` equals `success` (case-insensitive).

## Error Handling

```php
try {
    $response = $ds24->purchases->refund($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [refundPartially](refundPartially.md)
- [getPurchase](getPurchase.md)
- [updatePurchase](updatePurchase.md)
