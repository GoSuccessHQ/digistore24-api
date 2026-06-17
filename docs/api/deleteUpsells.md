# deleteUpsells

Delete all upsells for a product.

## Endpoint

```
POST /json/deleteUpsells
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
        'deleted' => true,
        'deleted_at' => '2025-03-21T01:30:00Z'
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

// Delete all upsells for product
$response = $api->upsells->deleteUpsells(
    productId: 123
);

if ($response->deleted) {
    echo "All upsells for product {$response->productId} deleted successfully\n";
    echo "Deleted at: {$response->deletedAt}\n";
}

// Example: Delete after confirmation
try {
    // Get current upsells first
    $current = $api->upsells->getUpsells(productId: 123);
    
    echo "About to delete {$current->totalUpsells} upsells\n";
    foreach ($current->upsells as $upsell) {
        echo "  - {$upsell->productName}\n";
    }
    
    // Proceed with deletion
    $response = $api->upsells->deleteUpsells(
        productId: 123
    );
    
    echo "All upsells deleted successfully\n";
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid product ID |
| 404 | Product not found | Specified product does not exist |
| 403 | Access denied | No permission to delete upsells for this product |

## Notes

- Deletes ALL upsells for the product
- Deletion is permanent and cannot be undone
- Does not affect completed purchases with upsells
- Statistics history for upsells will be lost
- Alternative: use `updateUpsells` with empty array
- Consider deactivating instead of deleting for historical data
