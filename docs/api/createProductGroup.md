# createProductGroup

Create a new product group.

## Endpoint

```
POST /json/createProductGroup
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `name` | string | Yes | Product group name |
| `description` | string | No | Group description |
| `product_ids` | array | No | Array of product IDs to add |
| `is_active` | bool | No | Active status (default: true) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'product_group_id' => 567,
        'name' => 'Premium Bundle',
        'description' => 'Collection of premium products',
        'product_ids' => [123, 124, 125],
        'product_count' => 3,
        'is_active' => true,
        'created_at' => '2025-03-20T20:00:00Z'
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

// Create product group
$response = $api->productGroups->createProductGroup(
    name: 'Premium Bundle'
);

echo "Product Group ID: {$response->productGroupId}\n";
echo "Name: {$response->name}\n";

// Create with products
$response = $api->productGroups->createProductGroup(
    name: 'Complete Course Bundle',
    description: 'All courses in one package',
    productIds: [123, 124, 125]
);

echo "Created group with {$response->productCount} products\n";

// Create detailed group
$response = $api->productGroups->createProductGroup(
    name: 'Starter Package',
    description: 'Perfect for beginners',
    productIds: [101, 102],
    isActive: true
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Missing name or invalid product IDs |
| 404 | Product not found | One or more product IDs do not exist |
| 403 | Access denied | No permission to create product groups |

## Notes

- Product groups used for organizing products
- Products can be in multiple groups
- Use for bundle offers or product categories
- Groups can be used in reporting and analytics
- Add products during creation or later via update
