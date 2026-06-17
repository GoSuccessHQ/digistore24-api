# startRebilling

Start or restart rebilling for a purchase.

## Endpoint

```
POST /json/startRebilling
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | Yes | Purchase ID |
| `next_rebill_date` | string | No | Next rebill date (Y-m-d, default: +interval days) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'purchase_id' => 'ABCD1234',
        'rebilling_status' => 'active',
        'next_rebill_date' => '2025-04-20',
        'rebill_amount' => 29.00,
        'currency' => 'EUR',
        'started_at' => '2025-03-20T22:15:00Z'
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

// Start rebilling with default next date
$response = $api->rebilling->startRebilling(
    purchaseId: 'ABCD1234'
);

echo "Rebilling Status: {$response->rebillingStatus}\n";
echo "Next Rebill Date: {$response->nextRebillDate}\n";
echo "Rebill Amount: {$response->currency} {$response->rebillAmount}\n";

// Start with custom next rebill date
$response = $api->rebilling->startRebilling(
    purchaseId: 'ABCD1234',
    nextRebillDate: '2025-04-15'
);

echo "Rebilling started, next charge on {$response->nextRebillDate}\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid purchase ID or date format |
| 404 | Purchase not found | Specified purchase does not exist |
| 403 | Access denied | No permission to start rebilling |
| 409 | Already active | Rebilling already active for this purchase |

## Notes

- Restarts subscription that was stopped
- Requires purchase with payment plan
- Next rebill date defaults to current date + payment plan interval
- Cannot start rebilling if payment method is invalid
- Use after payment method update or voluntary restart
