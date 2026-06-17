# updateProductGroup

Update an existing product group.

## Endpoint

```
POST /json/updateProductGroup
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_group_id` | int | Yes | Product group ID |
| `name` | string | No | Product group name |
| `description` | string | No | Group description |
| `product_ids` | array | No | Array of product IDs (replaces existing) |
| `is_active` | bool | No | Active status |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'product_group_id' => 567,
        'name' => 'Updated Premium Bundle',
        'description' => 'Updated collection of premium products',
        'product_ids' => [123, 124, 125, 126],
        'product_count' => 4,
        'is_active' => true,
        'updated_at' => '2025-03-20T20:45:00Z'
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

// Update group name
$response = $api->productGroups->updateProductGroup(
    productGroupId: 567,
    name: 'Updated Premium Bundle'
);

echo "Group updated: {$response->name}\n";

// Update description
$response = $api->productGroups->updateProductGroup(
    productGroupId: 567,
    description: 'Complete collection of all premium courses'
);

// Add/update products (replaces existing list)
$response = $api->productGroups->updateProductGroup(
    productGroupId: 567,
    productIds: [123, 124, 125, 126]
);

echo "Group now has {$response->productCount} products\n";

// Deactivate group
$response = $api->productGroups->updateProductGroup(
    productGroupId: 567,
    isActive: false
);

if (!$response->isActive) {
    echo "Group deactivated\n";
}

// Update multiple settings
$response = $api->productGroups->updateProductGroup(
    productGroupId: 567,
    name: 'Complete Premium Bundle',
    description: 'Everything you need to succeed',
    productIds: [123, 124, 125, 126, 127],
    isActive: true
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid product IDs or data |
| 404 | Product group not found | Specified product group does not exist |
| 403 | Access denied | No permission to update this product group |

## Notes

- Only provided parameters are updated
- `product_ids` replaces the entire product list (not additive)
- To add products, include all existing + new product IDs
- Other settings remain unchanged
- Changes take effect immediately
