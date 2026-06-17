# createShippingCostPolicy

Create a new shipping cost policy.

## Endpoint

```
POST /json/createShippingCostPolicy
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `name` | string | Yes | Policy name |
| `product_id` | int | Yes | Product ID |
| `country_code` | string | Yes | Country code (ISO 3166-1 alpha-2) |
| `cost` | float | Yes | Shipping cost |
| `currency` | string | No | Currency code (default: EUR) |
| `free_shipping_threshold` | float | No | Order value for free shipping |
| `is_active` | bool | No | Active status (default: true) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'policy_id' => 789,
        'name' => 'EU Standard Shipping',
        'product_id' => 123,
        'country_code' => 'DE',
        'cost' => 5.99,
        'currency' => 'EUR',
        'free_shipping_threshold' => 50.00,
        'is_active' => true,
        'created_at' => '2025-03-20T23:15:00Z'
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

// Create shipping policy
$response = $api->shipping->createShippingCostPolicy(
    name: 'Germany Standard Shipping',
    productId: 123,
    countryCode: 'DE',
    cost: 5.99
);

echo "Policy ID: {$response->policyId}\n";
echo "Name: {$response->name}\n";
echo "Cost: {$response->currency} {$response->cost}\n";

// Create with free shipping threshold
$response = $api->shipping->createShippingCostPolicy(
    name: 'US Shipping with Free Threshold',
    productId: 123,
    countryCode: 'US',
    cost: 9.99,
    currency: 'USD',
    freeShippingThreshold: 75.00
);

echo "Free shipping on orders over ${$response->freeShippingThreshold}\n";

// Create express shipping
$response = $api->shipping->createShippingCostPolicy(
    name: 'UK Express Shipping',
    productId: 123,
    countryCode: 'GB',
    cost: 15.00,
    currency: 'GBP'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid cost, country code, or product ID |
| 404 | Product not found | Specified product does not exist |
| 403 | Access denied | No permission to create shipping policies |
| 409 | Policy exists | Policy for this product/country already exists |

## Notes

- Country code must be ISO 3166-1 alpha-2 format (e.g., DE, US, GB)
- Cost must be positive number
- Free shipping threshold optional
- One policy per product/country combination
- Applies to physical products only
