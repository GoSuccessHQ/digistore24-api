# createRebillingPayment

Create a manual rebilling payment.

## Endpoint

```
POST /json/createRebillingPayment
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | Yes | Purchase ID with active subscription |
| `amount` | float | No | Payment amount (default: next rebill amount) |
| `currency` | string | No | Currency code (default: purchase currency) |
| `reason` | string | No | Reason for manual rebilling |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'rebilling_payment_id' => 'REBILL-12345',
        'purchase_id' => 'ABCD1234',
        'amount' => 29.00,
        'currency' => 'EUR',
        'status' => 'pending',
        'reason' => 'Manual rebilling requested',
        'created_at' => '2025-03-20T22:00:00Z'
    ]
]
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Create manual rebilling payment with default amount
$response = $api->rebilling->createRebillingPayment(
    purchaseId: 'ABCD1234'
);

echo "Rebilling Payment ID: {$response->rebillingPaymentId}\n";
echo "Amount: {$response->currency} {$response->amount}\n";
echo "Status: {$response->status}\n";

// Create with custom amount
$response = $api->rebilling->createRebillingPayment(
    purchaseId: 'ABCD1234',
    amount: 49.00,
    reason: 'Upgrade to premium tier'
);

// Create with custom currency
$response = $api->rebilling->createRebillingPayment(
    purchaseId: 'ABCD1234',
    amount: 35.00,
    currency: 'USD',
    reason: 'Manual billing cycle adjustment'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid purchase ID or amount |
| 404 | Purchase not found | Specified purchase does not exist |
| 403 | Access denied | No permission or no active subscription |
| 409 | Rebilling not active | Subscription is not active |

## Notes

- Requires active subscription for purchase
- Default amount is next scheduled rebill amount
- Payment processed immediately or at next billing cycle
- Use for missed payments or manual billing adjustments
- Does not affect regular rebilling schedule
