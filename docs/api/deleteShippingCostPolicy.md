# deleteShippingCostPolicy

Delete a shipping cost policy.

## Endpoint

```
POST /json/deleteShippingCostPolicy
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `policy_id` | int | Yes | Shipping cost policy ID to delete |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'policy_id' => 789,
        'deleted' => true,
        'deleted_at' => '2025-03-21T00:00:00Z'
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

// Delete shipping policy
$response = $api->shipping->deleteShippingCostPolicy(
    policyId: 789
);

if ($response->deleted) {
    echo "Shipping policy {$response->policyId} deleted successfully\n";
    echo "Deleted at: {$response->deletedAt}\n";
}

// Example: Delete after confirmation
try {
    // Get policy details first
    $policy = $api->shipping->getShippingCostPolicy(policyId: 789);
    
    echo "About to delete: {$policy->name}\n";
    echo "Country: {$policy->countryName}\n";
    echo "Orders using this policy: {$policy->ordersCount}\n";
    
    // Proceed with deletion
    $response = $api->shipping->deleteShippingCostPolicy(
        policyId: 789
    );
    
    echo "Policy deleted successfully\n";
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid policy ID |
| 404 | Policy not found | Specified shipping cost policy does not exist |
| 403 | Access denied | No permission to delete this policy |
| 409 | Policy in use | Cannot delete policy with active orders |

## Notes

- Deletion is permanent and cannot be undone
- Cannot delete policy with pending/active orders
- Deactivate policy first to prevent new usage
- Wait for pending orders to complete before deletion
- Consider keeping inactive policy for historical reference
