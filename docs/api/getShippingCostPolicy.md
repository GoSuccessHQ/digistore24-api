# getShippingCostPolicy

Get shipping cost policy details.

## Endpoint

```
POST /json/getShippingCostPolicy
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `policy_id` | int | Yes | Shipping cost policy ID |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'policy_id' => 789,
        'name' => 'EU Standard Shipping',
        'product_id' => 123,
        'product_name' => 'Physical Product',
        'country_code' => 'DE',
        'country_name' => 'Germany',
        'cost' => 5.99,
        'currency' => 'EUR',
        'free_shipping_threshold' => 50.00,
        'is_active' => true,
        'orders_count' => 245,
        'created_at' => '2025-01-15T10:00:00Z',
        'updated_at' => '2025-03-20T14:30:00Z'
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

// Get shipping policy details
$response = $api->shipping->getShippingCostPolicy(
    policyId: 789
);

echo "Policy: {$response->name}\n";
echo "Product: {$response->productName}\n";
echo "Country: {$response->countryName} ({$response->countryCode})\n";
echo "Cost: {$response->currency} {$response->cost}\n";

if ($response->freeShippingThreshold) {
    echo "Free shipping on orders over {$response->currency} {$response->freeShippingThreshold}\n";
}

echo "Status: " . ($response->isActive ? 'Active' : 'Inactive') . "\n";
echo "Orders using this policy: {$response->ordersCount}\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid policy ID |
| 404 | Policy not found | Specified shipping cost policy does not exist |
| 403 | Access denied | No permission to view this policy |

## Notes

- Includes product and country details
- Shows usage statistics (orders count)
- Use for policy review and analysis
