# getUpsells

Get upsells for a product.

## Endpoint

```
POST /json/getUpsells
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
        'product_id' => 123,
        'product_name' => 'Basic Course',
        'upsells' => [
            [
                'upsell_id' => 456,
                'product_id' => 124,
                'product_name' => 'Premium Course',
                'price' => 149.00,
                'currency' => 'EUR',
                'position' => 1,
                'is_active' => true,
                'conversions_count' => 67,
                'conversion_rate' => 8.9
            ],
            [
                'upsell_id' => 457,
                'product_id' => 125,
                'product_name' => 'VIP Course',
                'price' => 299.00,
                'currency' => 'EUR',
                'position' => 2,
                'is_active' => true,
                'conversions_count' => 34,
                'conversion_rate' => 4.5
            ]
            // ... more upsells
        ],
        'total_upsells' => 2
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

// Get upsells for product
$response = $api->upsells->getUpsells(
    productId: 123
);

echo "Product: {$response->productName}\n";
echo "Total Upsells: {$response->totalUpsells}\n\n";

foreach ($response->upsells as $upsell) {
    echo "Position {$upsell->position}: {$upsell->productName}\n";
    echo "Price: {$upsell->currency} {$upsell->price}\n";
    echo "Conversions: {$upsell->conversionsCount} ({$upsell->conversionRate}%)\n";
    echo "Status: " . ($upsell->isActive ? 'Active' : 'Inactive') . "\n\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid product ID |
| 404 | Product not found | Specified product does not exist |
| 403 | Access denied | No permission to view upsells for this product |

## Notes

- Upsells displayed after checkout in order of position
- Position determines display order (1 = first)
- Conversion rate = (conversions / offers shown) * 100
- Use for optimizing upsell funnels
- Inactive upsells not shown to customers
