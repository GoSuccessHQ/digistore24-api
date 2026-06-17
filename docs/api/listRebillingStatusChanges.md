# listRebillingStatusChanges

List rebilling status changes for a purchase.

## Endpoint

```
POST /json/listRebillingStatusChanges
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | Yes | Purchase ID |
| `start_date` | string | No | Start date (Y-m-d) |
| `end_date` | string | No | End date (Y-m-d) |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'purchase_id' => 'ABCD1234',
        'changes' => [
            [
                'change_id' => 1001,
                'old_status' => null,
                'new_status' => 'active',
                'reason' => 'Initial purchase',
                'changed_at' => '2025-01-20T10:00:00Z',
                'changed_by' => 'system'
            ],
            [
                'change_id' => 1002,
                'old_status' => 'active',
                'new_status' => 'stopped',
                'reason' => 'Customer cancellation',
                'changed_at' => '2025-03-15T14:30:00Z',
                'changed_by' => 'customer'
            ],
            [
                'change_id' => 1003,
                'old_status' => 'stopped',
                'new_status' => 'active',
                'reason' => 'Reactivated by customer',
                'changed_at' => '2025-03-20T22:45:00Z',
                'changed_by' => 'vendor'
            ]
            // ... more changes
        ],
        'total' => 3,
        'limit' => 100,
        'offset' => 0
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

// List all status changes for purchase
$response = $api->rebilling->listRebillingStatusChanges(
    purchaseId: 'ABCD1234'
);

echo "Total changes: {$response->total}\n\n";
foreach ($response->changes as $change) {
    echo "Change #{$change->changeId}\n";
    echo "  From: " . ($change->oldStatus ?? 'N/A') . "\n";
    echo "  To: {$change->newStatus}\n";
    echo "  Reason: {$change->reason}\n";
    echo "  When: {$change->changedAt}\n";
    echo "  By: {$change->changedBy}\n\n";
}

// Filter by date range
$response = $api->rebilling->listRebillingStatusChanges(
    purchaseId: 'ABCD1234',
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);

// Pagination
$response = $api->rebilling->listRebillingStatusChanges(
    purchaseId: 'ABCD1234',
    limit: 20,
    offset: 0
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid purchase ID or date format |
| 404 | Purchase not found | Specified purchase does not exist |
| 403 | Access denied | No permission to view rebilling changes |

## Notes

- Shows complete history of subscription status changes
- Status values: `active`, `stopped`, `paused`, `failed`
- Changed by: `system`, `customer`, `vendor`, `payment_processor`
- Results ordered by change date (newest first)
- Max 500 results per request
- Use for subscription lifecycle analysis
