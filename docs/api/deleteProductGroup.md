# deleteProductGroup

Delete a product group.

## Endpoint

```
POST /json/deleteProductGroup
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_group_id` | int | Yes | Product group ID to delete |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'product_group_id' => 567,
        'deleted' => true,
        'deleted_at' => '2025-03-20T21:00:00Z'
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

// Delete product group
$response = $api->productGroups->deleteProductGroup(
    productGroupId: 567
);

if ($response->deleted) {
    echo "Product group {$response->productGroupId} deleted successfully\n";
    echo "Deleted at: {$response->deletedAt}\n";
}

// Example: Delete after confirmation
try {
    // Get group details first
    $group = $api->productGroups->getProductGroup(productGroupId: 567);
    
    echo "About to delete: {$group->name}\n";
    echo "Contains {$group->productCount} products\n";
    
    // Proceed with deletion
    $response = $api->productGroups->deleteProductGroup(
        productGroupId: 567
    );
    
    echo "Group deleted successfully\n";
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid product group ID |
| 404 | Product group not found | Specified product group does not exist |
| 403 | Access denied | No permission to delete this product group |

## Notes

- Deletion is permanent and cannot be undone
- Deleting a group does NOT delete the products in it
- Products will remain accessible individually
- Statistics history for the group will be lost
- Consider deactivating instead of deleting for historical data
- Export statistics before deletion if needed
