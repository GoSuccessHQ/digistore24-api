# deletePaymentplan

Delete a payment plan.

## Endpoint

```
POST /json/deletePaymentplan
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `paymentplan_id` | int | Yes | Payment plan ID to delete |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'paymentplan_id' => 789,
        'deleted' => true,
        'deleted_at' => '2025-03-20T19:30:00Z'
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

// Delete payment plan
$response = $api->paymentPlans->deletePaymentplan(
    paymentplanId: 789
);

if ($response->deleted) {
    echo "Payment plan {$response->paymentplanId} deleted successfully\n";
    echo "Deleted at: {$response->deletedAt}\n";
}

// Example: Check before deletion
try {
    // Get plan details first
    $plans = $api->paymentPlans->listPaymentPlans(productId: 123);
    
    foreach ($plans->paymentplans as $plan) {
        if ($plan->activeSubscriptions == 0 && !$plan->isActive) {
            // Safe to delete - no active subscriptions
            $response = $api->paymentPlans->deletePaymentplan(
                paymentplanId: $plan->paymentplanId
            );
            echo "Deleted inactive plan: {$plan->name}\n";
        } else {
            echo "Skipping plan '{$plan->name}' - has active subscriptions\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid payment plan ID |
| 404 | Payment plan not found | Specified payment plan does not exist |
| 403 | Access denied | No permission to delete this payment plan |
| 409 | Plan in use | Cannot delete plan with active subscriptions |

## Notes

- Deletion is permanent and cannot be undone
- Payment plans with active subscriptions cannot be deleted
- Deactivate plan first to prevent new subscriptions
- Wait for existing subscriptions to end before deletion
- Alternative: keep inactive plan for historical reference
- Statistics history will be lost after deletion
- Consider exporting subscription data before deletion
