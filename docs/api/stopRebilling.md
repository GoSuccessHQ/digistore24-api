# stopRebilling

Stop rebilling for a purchase.

## Endpoint

```
POST /json/stopRebilling
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | Yes | Purchase ID |
| `reason` | string | No | Reason for stopping (cancellation, payment_failed, etc.) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'purchase_id' => 'ABCD1234',
        'rebilling_status' => 'stopped',
        'stopped_at' => '2025-03-20T22:30:00Z',
        'reason' => 'Customer cancellation',
        'access_until' => '2025-04-20'
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

// Stop rebilling without reason
$response = $api->rebilling->stopRebilling(
    purchaseId: 'ABCD1234'
);

echo "Rebilling Status: {$response->rebillingStatus}\n";
echo "Stopped at: {$response->stoppedAt}\n";
echo "Access until: {$response->accessUntil}\n";

// Stop with reason
$response = $api->rebilling->stopRebilling(
    purchaseId: 'ABCD1234',
    reason: 'Customer cancellation'
);

echo "Subscription cancelled: {$response->reason}\n";

// Stop due to payment failure
$response = $api->rebilling->stopRebilling(
    purchaseId: 'ABCD1234',
    reason: 'payment_failed'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid purchase ID |
| 404 | Purchase not found | Specified purchase does not exist |
| 403 | Access denied | No permission to stop rebilling |
| 409 | Already stopped | Rebilling already stopped for this purchase |

## Notes

- Cancels future automatic payments
- Customer retains access until current period ends
- Can be restarted later with `startRebilling`
- Common reasons: `cancellation`, `payment_failed`, `refund`, `customer_request`
- Does not refund current period
