# updateProduct

Update an existing product on Digistore24.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateProduct`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/updateProduct.yaml)

## Parameters

### Required Parameters

- `product_id` (integer) - The Digistore24 product ID

### Optional Parameters (Update Fields)

- `name_de` (string, max 63 chars) - Product name in German
- `name_en` (string, max 63 chars) - Product name in English
- `name_es` (string, max 63 chars) - Product name in Spanish
- `name_intern` (string, max 63 chars) - Internal product name
- `description_de` (string) - Product description in German (filtered HTML)
- `description_en` (string) - Product description in English (filtered HTML)
- `description_es` (string) - Product description in Spanish (filtered HTML)
- `salespage_url` (string, max 255 chars) - URL of the sales page
- `upsell_salespage_url` (string, max 255 chars) - URL of the upsell sales page
- `thankyou_url` (string, max 255 chars) - URL of the thank you page
- `image_url` (string, max 255 chars) - URL of the product image
- `product_type_id` (integer) - Product type ID (call `getGlobalSettings` for valid IDs)
- `currency` (string) - List of possible currencies (e.g., "USD,EUR")
- `approval_status` (string) - Approval status: `new` or `pending`
- `affiliate_commision` (float) - Commission for affiliates (Note: API uses 'commision' spelling)
- `buyer_type` (string) - `consumer` (prices include VAT) or `business` (prices exclude VAT)
- `is_address_input_mandatory` (boolean) - True if buyer must always enter address
- `add_order_data_to_thankyou_page_url` (boolean) - True if order data is added to thankyou URL

## Response

```json
{
  "data": {
    "modified": "Y"
  }
}
```

### Response Fields

- `modified` (string) - `Y` if product was modified, `N` if no changes were made

## Usage Example

```php
use Digistore24\Request\Product\UpdateProductRequest;

$request = new UpdateProductRequest(
    productId: 12345,
    nameEn: 'Updated Product Name',
    nameDe: 'Aktualisierter Produktname',
    salespageUrl: 'https://example.com/new-sales-page'
);

try {
    $response = $digistore24->products->update($request);
    
    if ($response->wasModified()) {
        echo "Product updated successfully";
    } else {
        echo "No changes were made";
    }
} catch (\Digistore24\Exception\ApiException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Update Product Names

```php
$request = new UpdateProductRequest(
    productId: 12345,
    nameEn: 'Professional Course 2024',
    nameDe: 'Professioneller Kurs 2024',
    nameEs: 'Curso Profesional 2024'
);

$response = $digistore24->products->update($request);
echo $response->wasModified() ? "Names updated" : "No changes";
```

## Update Product URLs

```php
$request = new UpdateProductRequest(
    productId: 12345,
    salespageUrl: 'https://example.com/new-sales',
    thankyouUrl: 'https://example.com/new-thankyou',
    upsellSalespageUrl: 'https://example.com/upsell'
);

$response = $digistore24->products->update($request);
```

## Update Product Description

```php
$request = new UpdateProductRequest(
    productId: 12345,
    descriptionEn: '<h2>New Features</h2><p>Updated content...</p>',
    descriptionDe: '<h2>Neue Funktionen</h2><p>Aktualisierter Inhalt...</p>',
    imageUrl: 'https://example.com/new-product-image.jpg'
);

$response = $digistore24->products->update($request);
```

## Update Commission Settings

```php
$request = new UpdateProductRequest(
    productId: 12345,
    affiliateCommission: 75.00, // Increase affiliate commission to 75
    buyerType: 'consumer', // Prices include VAT
    currency: 'USD,EUR,GBP' // Accept multiple currencies
);

$response = $digistore24->products->update($request);
```

## Change Product Type

```php
$request = new UpdateProductRequest(
    productId: 12345,
    productTypeId: 3, // Change to subscription
    isAddressInputMandatory: false, // No shipping address needed
    approvalStatus: 'pending' // Submit for approval
);

$response = $digistore24->products->update($request);
```

## Batch Update Multiple Fields

```php
$request = new UpdateProductRequest(
    productId: 12345,
    nameIntern: 'product-v2-final',
    nameEn: 'Product Version 2',
    descriptionEn: '<p>Completely redesigned product</p>',
    salespageUrl: 'https://example.com/v2',
    thankyouUrl: 'https://example.com/v2-thankyou',
    imageUrl: 'https://example.com/v2-image.jpg',
    affiliateCommission: 60.00,
    addOrderDataToThankyouPageUrl: true
);

$response = $digistore24->products->update($request);
```

## Error Handling

```php
use Digistore24\Exception\ValidationException;
use Digistore24\Exception\NotFoundException;
use Digistore24\Exception\ApiException;

try {
    $response = $digistore24->products->update($request);
    
    if ($response->wasModified()) {
        echo "Product updated successfully";
    } else {
        echo "No changes detected";
    }
} catch (NotFoundException $e) {
    // Product not found
    echo "Product not found: " . $e->getMessage();
} catch (ValidationException $e) {
    // Invalid parameters
    echo "Validation error: " . $e->getMessage();
} catch (ApiException $e) {
    // General API error
    echo "API error: " . $e->getMessage();
}
```

## Important Notes

- **Partial Updates**: Only include fields you want to change; other fields remain unchanged
- **Response Checking**: Use `wasModified()` to verify if changes were actually applied
- **API Spelling**: Note that the API uses `affiliate_commision` (not 'commission')
- **Boolean vs String**: Some fields use boolean (true/false) while others use string ('Y'/'N')
- **HTML Filtering**: Description fields support filtered HTML for formatting
- **Currency Format**: Multiple currencies are comma-separated (e.g., "USD,EUR,GBP")
- **Product Type Changes**: Changing product type may affect available features
- **Approval Status**: Changes to approval status apply to all resellers of the vendor

## Related Endpoints

- [getProduct](getProduct.md) - Get current product details before updating
- [createProduct](createProduct.md) - Create a new product
- [copyProduct](copyProduct.md) - Copy product as a starting point for updates
- [listProducts](listProducts.md) - List all products
- [deleteProduct](deleteProduct.md) - Delete a product
