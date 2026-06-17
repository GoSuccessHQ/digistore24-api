# listConversionTools

List all conversion tools (vouchers, bundles, upsells) for a product.

## Endpoint

```
POST /json/listConversionTools
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | Yes | Product ID |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'product_id' => 12345,
        'vouchers' => [
            [
                'voucher_id' => 789,
                'code' => 'SUMMER2025',
                'discount_type' => 'percentage',
                'discount_value' => 20.0,
                'is_active' => true
            ],
            // ... more vouchers
        ],
        'upsells' => [
            [
                'upsell_id' => 456,
                'product_name' => 'Premium Upgrade',
                'position' => 1,
                'is_active' => true
            ]
        ],
        'bundles' => []
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

// Get all conversion tools for a product
$response = $api->conversionTools->listConversionTools(
    productId: 12345
);

echo "Vouchers: " . count($response->vouchers) . "\n";
echo "Upsells: " . count($response->upsells) . "\n";
echo "Bundles: " . count($response->bundles) . "\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | Product not found | Product does not exist |
| 403 | Access denied | Not authorized to access this product |

## Notes

- Returns all active and inactive conversion tools
- Use to audit and manage product conversion strategy
- Includes vouchers, upsells, and product bundles
