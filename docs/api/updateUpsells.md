# updateUpsells

Update upsells for a product.

## Endpoint

```
POST /json/updateUpsells
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | Yes | Product ID |
| `upsells` | array | Yes | Array of upsell configurations |

Each upsell object:
- `product_id` (int, required): Upsell product ID
- `position` (int, required): Display position
- `is_active` (bool, optional): Active status

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
                'position' => 1,
                'is_active' => true
            ],
            [
                'upsell_id' => 457,
                'product_id' => 125,
                'product_name' => 'VIP Course',
                'position' => 2,
                'is_active' => true
            ]
        ],
        'updated_at' => '2025-03-21T01:15:00Z'
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

// Update upsells for product
$response = $api->upsells->updateUpsells(
    productId: 123,
    upsells: [
        [
            'product_id' => 124,
            'position' => 1,
            'is_active' => true
        ],
        [
            'product_id' => 125,
            'position' => 2,
            'is_active' => true
        ]
    ]
);

echo "Upsells updated for: {$response->productName}\n";
echo "Total upsells: " . count($response->upsells) . "\n";

// Add single upsell
$response = $api->upsells->updateUpsells(
    productId: 123,
    upsells: [
        [
            'product_id' => 124,
            'position' => 1,
            'is_active' => true
        ]
    ]
);

// Deactivate specific upsell
$response = $api->upsells->updateUpsells(
    productId: 123,
    upsells: [
        [
            'product_id' => 124,
            'position' => 1,
            'is_active' => false  // Deactivated
        ],
        [
            'product_id' => 125,
            'position' => 2,
            'is_active' => true
        ]
    ]
);

// Reorder upsells
$response = $api->upsells->updateUpsells(
    productId: 123,
    upsells: [
        [
            'product_id' => 125,
            'position' => 1  // Now first
        ],
        [
            'product_id' => 124,
            'position' => 2  // Now second
        ]
    ]
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid product IDs or positions |
| 404 | Product not found | Specified product does not exist |
| 403 | Access denied | No permission to update upsells for this product |

## Notes

- Replaces entire upsell configuration
- To remove all upsells, pass empty array
- Position must be unique for each upsell
- Positions determine display order (1 = first)
- Changes take effect immediately
- Cannot upsell product to itself
