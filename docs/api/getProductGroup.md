# getProductGroup

Get product group details.

## Endpoint

```
POST /json/getProductGroup
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_group_id` | int | Yes | Product group ID |

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
        'products' => [
            [
                'product_id' => 123,
                'name' => 'Premium Course A',
                'price' => 99.00
            ],
            [
                'product_id' => 124,
                'name' => 'Premium Course B',
                'price' => 149.00
            ],
            [
                'product_id' => 125,
                'name' => 'Premium Course C',
                'price' => 199.00
            ]
        ],
        'is_active' => true,
        'total_sales' => 245,
        'total_revenue' => 109735.00,
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

// Get product group details
$response = $api->productGroups->getProductGroup(
    productGroupId: 567
);

echo "Group: {$response->name}\n";
echo "Description: {$response->description}\n";
echo "Products: {$response->productCount}\n";
echo "Total Sales: {$response->totalSales}\n";
echo "Total Revenue: € {$response->totalRevenue}\n\n";

// List products in group
echo "Products in this group:\n";
foreach ($response->products as $product) {
    echo "  - {$product->name} (€ {$product->price})\n";
}

// Check if group is active
if ($response->isActive) {
    echo "\nGroup is active\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid product group ID |
| 404 | Product group not found | Specified product group does not exist |
| 403 | Access denied | No permission to access this product group |

## Notes

- Includes detailed product information
- Shows sales and revenue statistics
- Statistics updated daily
- Use for bundle performance analysis
