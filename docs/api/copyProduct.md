# copyProduct

Copy an existing product on Digistore24 with optional modifications.

## Endpoint

**POST** `https://www.digistore24.com/api/call/copyProduct`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/copyProduct.yaml)

## Parameters

### Required Parameters

- `product_id` (string) - The ID of the product to be copied

### Optional Parameters (Data Modifications)

- `name_intern` (string, max 63 chars) - Internal product name
- `product_type_id` (integer) - Product type ID (call `getGlobalSettings` for valid IDs)
- `language` (string) - Comma separated list of languages (e.g., "en,de")
- `is_active` (string) - Product activation status: `Y` or `N`
- `product_group_id` (integer) - Product group ID
- `name_de` (string, max 63 chars) - German product name
- `name_en` (string, max 63 chars) - English product name
- `name_es` (string, max 63 chars) - Spanish product name

## Response

```json
{
  "product_id": 12346
}
```

### Response Fields

- `product_id` (integer) - ID of the newly created product copy

## Usage Example

```php
use Digistore24\Request\Product\CopyProductRequest;

$request = new CopyProductRequest(
    productId: 12345,
    nameIntern: 'my-product-v2',
    nameEn: 'My Product V2',
    isActive: 'N' // Create as inactive initially
);

try {
    $response = $digistore24->products->copy($request);
    echo "Product copied with new ID: " . $response->productId;
} catch (\Digistore24\Exception\ApiException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Copy Product with New Name

```php
$request = new CopyProductRequest(
    productId: 12345,
    nameIntern: 'product-copy-2024',
    nameEn: 'Updated Product Name 2024',
    nameDe: 'Aktualisierter Produktname 2024'
);

$response = $digistore24->products->copy($request);
echo "New product ID: " . $response->productId;
```

## Copy Product to Different Type

```php
$request = new CopyProductRequest(
    productId: 12345,
    productTypeId: 3, // Change product type
    nameIntern: 'product-different-type'
);

$response = $digistore24->products->copy($request);
echo "Product copied with new type: " . $response->productId;
```

## Copy with Multi-Language Support

```php
$request = new CopyProductRequest(
    productId: 12345,
    nameIntern: 'multilingual-product',
    language: 'en,de,es', // Add multiple languages
    nameEn: 'International Product',
    nameDe: 'Internationales Produkt',
    nameEs: 'Producto Internacional'
);

$response = $digistore24->products->copy($request);
echo "Multilingual product created: " . $response->productId;
```

## Copy Product as Template

```php
// Copy a product as an inactive template for future use
$request = new CopyProductRequest(
    productId: 12345,
    nameIntern: 'template-product-2024',
    isActive: 'N', // Keep it inactive
    nameEn: 'Template Product'
);

$response = $digistore24->products->copy($request);
echo "Template created: " . $response->productId;
```

## Error Handling

```php
use Digistore24\Exception\ValidationException;
use Digistore24\Exception\NotFoundException;
use Digistore24\Exception\ForbiddenException;
use Digistore24\Exception\ApiException;

try {
    $response = $digistore24->products->copy($request);
    echo "Product copied successfully: " . $response->productId;
} catch (NotFoundException $e) {
    // Source product not found
    echo "Source product not found: " . $e->getMessage();
} catch (ValidationException $e) {
    // Invalid parameters
    echo "Validation error: " . $e->getMessage();
} catch (ForbiddenException $e) {
    // Full access required
    echo "Access denied: " . $e->getMessage();
} catch (ApiException $e) {
    // General API error
    echo "API error: " . $e->getMessage();
}
```

## Important Notes

- **Full Access Required**: This endpoint requires a full access API key
- **Selective Copying**: All product settings are copied except those you explicitly modify
- **Default Language**: If language is not specified, the current vendor's language is used
- **Product Groups**: You can assign the copy to a different product group
- **Inactive Copies**: Consider creating copies as inactive (`is_active: 'N'`) to review before publishing
- **Name Requirements**: Product names must not exceed 63 characters
- **Use Cases**: Useful for creating product variants, templates, or seasonal versions

## Related Endpoints

- [getProduct](getProduct.md) - Get product details before copying
- [createProduct](createProduct.md) - Create a new product from scratch
- [updateProduct](updateProduct.md) - Update the copied product
- [listProducts](listProducts.md) - List all products including copies
- [deleteProduct](deleteProduct.md) - Delete unwanted copies
