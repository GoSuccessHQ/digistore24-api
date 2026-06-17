# listProductGroups

List all product groups.

## Endpoint

```
POST /json/listProductGroups
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `is_active` | bool | No | Filter by active status |
| `product_id` | int | No | Filter groups containing this product |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'product_groups' => [
            [
                'product_group_id' => 567,
                'name' => 'Premium Bundle',
                'description' => 'Collection of premium products',
                'product_count' => 3,
                'is_active' => true,
                'total_sales' => 245,
                'total_revenue' => 109735.00,
                'created_at' => '2025-01-15T10:00:00Z'
            ],
            [
                'product_group_id' => 568,
                'name' => 'Starter Package',
                'description' => 'Perfect for beginners',
                'product_count' => 2,
                'is_active' => true,
                'total_sales' => 187,
                'total_revenue' => 45780.00,
                'created_at' => '2025-02-10T14:00:00Z'
            ]
            // ... more groups
        ],
        'total' => 12,
        'limit' => 100,
        'offset' => 0
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

// List all product groups
$response = $api->productGroups->listProductGroups(
    limit: 50
);

echo "Total: {$response->total} product groups\n\n";
foreach ($response->productGroups as $group) {
    echo "ID: {$group->productGroupId}\n";
    echo "Name: {$group->name}\n";
    echo "Products: {$group->productCount}\n";
    echo "Sales: {$group->totalSales}\n";
    echo "Revenue: € {$group->totalRevenue}\n";
    echo "Status: " . ($group->isActive ? 'Active' : 'Inactive') . "\n\n";
}

// Filter active groups only
$response = $api->productGroups->listProductGroups(
    isActive: true
);

// Find groups containing specific product
$response = $api->productGroups->listProductGroups(
    productId: 123
);

echo "Product 123 is in {$response->total} groups\n";

// Pagination
$response = $api->productGroups->listProductGroups(
    limit: 20,
    offset: 0
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid filter values or pagination parameters |

## Notes

- Results ordered by creation date (newest first)
- Includes sales and revenue statistics
- Max 500 results per request
- Use pagination for large result sets
- Statistics updated daily
