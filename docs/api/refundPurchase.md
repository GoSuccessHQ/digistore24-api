# refundPurchase

Refund all payments of an order according to the refund policy.

## Endpoint

**POST** `https://www.digistore24.com/api/call/refundPurchase`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/refundPurchase.yaml)

## Parameters

### Required Parameters

- `purchase_id` (string) - The purchase ID

### Optional Parameters

- `force` (boolean) - If false (default), refund only if policy allows. If true, attempt anyway.
- `request_date` (string) - Apply refund policies based on this date (default: 'now')

## Response

```json
{
  "result": "success",
  "data": {}
}
```

## Usage Example

```php
use Digistore24\Request\Purchase\RefundPurchaseRequest;

$request = new RefundPurchaseRequest(
    purchaseId: 'ABCD-1234-EFGH'
);

$response = $digistore24->purchases->refund($request);

if ($response->wasSuccessful()) {
    echo "Refund processed successfully";
} else {
    echo "Refund failed: {$response->result}";
}
```

## Force Refund

```php
// Bypass refund policy and attempt refund anyway
$request = new RefundPurchaseRequest(
    purchaseId: 'ABCD-1234',
    force: true
);

$response = $digistore24->purchases->refund($request);
```

## Backdated Refund

```php
// Apply refund policy as if requested on a specific date
$request = new RefundPurchaseRequest(
    purchaseId: 'ABCD-1234',
    requestDate: '2024-01-15'
);

$response = $digistore24->purchases->refund($request);
```

## Important Notes

- **Policy Compliance**: By default, respects refund policy settings
- **Force Option**: Use with caution - bypasses policy checks
- **Processing Delay**: Use `request_date` if there's a delay between request and processing
- **Full Refund**: Refunds all payments that may be refunded

## Related Endpoints

- [getPurchase](getPurchase.md) - Check purchase details before refunding
- [updatePurchase](updatePurchase.md) - Update purchase information
