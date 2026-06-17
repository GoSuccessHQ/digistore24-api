# deleteProduct

Delete a product from Digistore24. This operation cannot be undone.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteProduct`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/deleteProduct.yaml)

## Parameters

### Required Parameters

- `product_id` (integer) - ID of the product to delete

## Response

```json
{
  "success": true
}
```

### Response Fields

- `success` (boolean) - True if the product was successfully deleted

## Usage Example

```php
use Digistore24\Request\Product\DeleteProductRequest;

$request = new DeleteProductRequest(
    productId: 12345
);

try {
    $response = $digistore24->products->delete($request);
    
    if ($response->success) {
        echo "Product deleted successfully";
    }
} catch (\Digistore24\Exception\ApiException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Delete with Confirmation

```php
use Digistore24\Request\Product\GetProductRequest;
use Digistore24\Request\Product\DeleteProductRequest;

// First, verify product exists and get details
$getRequest = new GetProductRequest(productId: 12345);
$product = $digistore24->products->get($getRequest);

echo "About to delete: " . $product->name . "\n";
$confirmation = readline("Are you sure? (yes/no): ");

if (strtolower($confirmation) === 'yes') {
    $deleteRequest = new DeleteProductRequest(productId: 12345);
    $response = $digistore24->products->delete($deleteRequest);
    echo "Product deleted";
} else {
    echo "Deletion cancelled";
}
```

## Delete Multiple Products

```php
$productIdsToDelete = [12345, 12346, 12347];
$deleted = [];
$failed = [];

foreach ($productIdsToDelete as $productId) {
    try {
        $request = new DeleteProductRequest(productId: $productId);
        $response = $digistore24->products->delete($request);
        
        if ($response->success) {
            $deleted[] = $productId;
        }
    } catch (\Digistore24\Exception\ApiException $e) {
        $failed[$productId] = $e->getMessage();
    }
}

echo "Deleted: " . count($deleted) . " products\n";
echo "Failed: " . count($failed) . " products\n";
```

## Safe Delete with Backup

```php
use Digistore24\Request\Product\GetProductRequest;
use Digistore24\Request\Product\DeleteProductRequest;

// Get product details before deleting
$getRequest = new GetProductRequest(productId: 12345);
$product = $digistore24->products->get($getRequest);

// Save product data for backup
$backup = json_encode([
    'id' => $product->id,
    'name' => $product->name,
    'deleted_at' => date('Y-m-d H:i:s'),
    'product_data' => $product
]);

file_put_contents("product_backup_{$product->id}.json", $backup);

// Now delete
$deleteRequest = new DeleteProductRequest(productId: 12345);
$response = $digistore24->products->delete($deleteRequest);

echo "Product deleted and backed up";
```

## Delete Old Test Products

```php
use Digistore24\Request\Product\ListProductsRequest;
use Digistore24\Request\Product\DeleteProductRequest;

// List all products
$listRequest = new ListProductsRequest();
$productList = $digistore24->products->list($listRequest);

foreach ($productList->products as $product) {
    // Delete products with 'test' in the name
    if (str_contains(strtolower($product->name), 'test')) {
        try {
            $deleteRequest = new DeleteProductRequest(productId: $product->id);
            $response = $digistore24->products->delete($deleteRequest);
            echo "Deleted test product: {$product->name}\n";
        } catch (\Digistore24\Exception\ApiException $e) {
            echo "Failed to delete {$product->id}: {$e->getMessage()}\n";
        }
    }
}
```

## Error Handling

```php
use Digistore24\Exception\NotFoundException;
use Digistore24\Exception\ForbiddenException;
use Digistore24\Exception\AuthenticationException;
use Digistore24\Exception\ApiException;

try {
    $request = new DeleteProductRequest(productId: 12345);
    $response = $digistore24->products->delete($request);
    echo "Product deleted successfully";
} catch (NotFoundException $e) {
    // Product doesn't exist or already deleted
    echo "Product not found: " . $e->getMessage();
} catch (ForbiddenException $e) {
    // Insufficient access rights
    echo "Access denied: " . $e->getMessage();
} catch (AuthenticationException $e) {
    // Invalid or missing API key
    echo "Authentication failed: " . $e->getMessage();
} catch (ApiException $e) {
    // General API error
    echo "API error: " . $e->getMessage();
}
```

## Important Notes

- **⚠️ Permanent Deletion**: This operation cannot be undone. The product is permanently deleted.
- **Full Access Required**: This endpoint requires a full access API key
- **No Soft Delete**: There is no "archive" or "soft delete" - products are completely removed
- **Active Purchases**: Consider the impact on customers with active purchases
- **Buy URLs**: All associated buy URLs will also be deleted
- **Affiliates**: Affiliate links to this product will stop working
- **Backup First**: Consider backing up product data before deletion
- **404 Response**: If the product doesn't exist, you'll receive a 404 Not Found error
- **Batch Operations**: When deleting multiple products, handle errors gracefully

## Best Practices

1. **Verify Before Deletion**: Always get product details first to confirm you're deleting the right product
2. **Create Backups**: Export product data before deletion for record-keeping
3. **User Confirmation**: Require explicit confirmation for deletion operations
4. **Check Dependencies**: Ensure no active subscriptions or ongoing purchases depend on the product
5. **Audit Trail**: Log all deletion operations with timestamps and reasons
6. **Access Control**: Restrict deletion permissions to authorized users only

## Related Endpoints

- [getProduct](getProduct.md) - Verify product exists before deleting
- [listProducts](listProducts.md) - List products to identify deletion candidates
- [updateProduct](updateProduct.md) - Consider deactivating instead of deleting
- [createProduct](createProduct.md) - Recreate a product if accidentally deleted
- [copyProduct](copyProduct.md) - Create a backup copy before deletion
