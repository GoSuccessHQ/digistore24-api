# updateShippingCostPolicy

Update an existing shipping cost policy.

## Endpoint

```
POST /json/updateShippingCostPolicy
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `policy_id` | int | Yes | Shipping cost policy ID |
| `name` | string | No | Policy name |
| `cost` | float | No | Shipping cost |
| `free_shipping_threshold` | float | No | Order value for free shipping |
| `is_active` | bool | No | Active status |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'policy_id' => 789,
        'name' => 'Updated EU Standard Shipping',
        'product_id' => 123,
        'country_code' => 'DE',
        'cost' => 6.99,
        'currency' => 'EUR',
        'free_shipping_threshold' => 45.00,
        'is_active' => true,
        'updated_at' => '2025-03-20T23:45:00Z'
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

// Update policy name
$response = $api->shipping->updateShippingCostPolicy(
    policyId: 789,
    name: 'Updated EU Standard Shipping'
);

echo "Policy updated: {$response->name}\n";

// Update shipping cost
$response = $api->shipping->updateShippingCostPolicy(
    policyId: 789,
    cost: 6.99
);

echo "New cost: {$response->currency} {$response->cost}\n";

// Update free shipping threshold
$response = $api->shipping->updateShippingCostPolicy(
    policyId: 789,
    freeShippingThreshold: 45.00
);

// Remove free shipping threshold
$response = $api->shipping->updateShippingCostPolicy(
    policyId: 789,
    freeShippingThreshold: 0
);

// Deactivate policy
$response = $api->shipping->updateShippingCostPolicy(
    policyId: 789,
    isActive: false
);

// Update multiple settings
$response = $api->shipping->updateShippingCostPolicy(
    policyId: 789,
    name: 'Premium EU Shipping',
    cost: 7.99,
    freeShippingThreshold: 60.00,
    isActive: true
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid cost or policy ID |
| 404 | Policy not found | Specified shipping cost policy does not exist |
| 403 | Access denied | No permission to update this policy |

## Notes

- Only provided parameters are updated
- Other settings remain unchanged
- Cannot change product_id or country_code (create new policy instead)
- Changes apply to new orders immediately
- Existing orders use original shipping cost
