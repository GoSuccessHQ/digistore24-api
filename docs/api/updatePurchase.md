# updatePurchase

Update purchase tracking data and extend rebilling payment intervals.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updatePurchase`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/updatePurchase.yaml)

## Parameters

### Required Parameters

- `purchase_id` (string) - The ID of the purchase to update

### Optional Parameters

- `tracking_param` (string) - The vendor's tracking key
- `custom` (string) - The custom field
- `unlock_invoices` (boolean) - Grant buyer access to order details and invoices (access expires after 3 years by default)
- `next_payment_at` (string) - Extend rebilling payment interval (date-time format) - cannot shorten intervals

## Response

```json
{
  "data": {
    "is_modified": "Y"
  }
}
```

## Usage Example

```php
use Digistore24\Request\Purchase\UpdatePurchaseRequest;

$request = new UpdatePurchaseRequest(
    purchaseId: 'ABCD-1234-EFGH',
    trackingParam: 'campaign_123',
    custom: 'customer_reference_456',
    unlockInvoices: true
);

$response = $digistore24->purchases->update($request);

if ($response->wasModified()) {
    echo "Purchase updated successfully";
} else {
    echo "No changes made";
}
```

## Extend Payment Pause

```php
$request = new UpdatePurchaseRequest(
    purchaseId: 'ABCD-1234',
    nextPaymentAt: '2024-06-01 00:00:00' // Grant payment pause
);

$response = $digistore24->purchases->update($request);
```

## Important Notes

- **Partial Updates**: Only include fields you want to change
- **Payment Intervals**: Can only extend (not shorten) rebilling intervals
- **Invoice Access**: Use `unlock_invoices` to restore access after 3-year expiry

## Related Endpoints

- [getPurchase](getPurchase.md) - Get current purchase details
- [refundPurchase](refundPurchase.md) - Refund a purchase
