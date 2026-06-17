# createProduct

Create a new product on Digistore24.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createProduct`

## OpenAPI Specification

[View OpenAPI Spec](https://digistore24.com/api/docs/paths/createProduct.yaml)

## Parameters

### Required Parameters

- `name_intern` (string, max 63 chars) - Internal product name

### Optional Parameters

- `name_de` (string, max 63 chars) - German product name
- `name_en` (string, max 63 chars) - English product name
- `name_es` (string, max 63 chars) - Spanish product name
- `description_de` (string) - German product description (filtered HTML)
- `description_en` (string) - English product description (filtered HTML)
- `description_es` (string) - Spanish product description (filtered HTML)
- `salespage_url` (string, max 255 chars) - Sales page URL
- `upsell_salespage_url` (string, max 255 chars) - Upsell sales page URL
- `thankyou_url` (string, max 255 chars) - Thank you page URL
- `image_url` (string, max 255 chars) - Product image URL
- `product_type_id` (integer) - Product type ID (see `getGlobalSettings` for valid IDs)
- `approval_status` (string) - Product approval status: `new` or `pending`
- `affiliate_commission` (float) - Affiliate commission amount
- `buyer_type` (string) - `consumer` (prices include VAT) or `business` (prices exclude VAT)
- `is_address_input_mandatory` (string) - `Y` = buyer must always enter address, `N` = only when required for delivery
- `add_order_data_to_thankyou_page_url` (string) - `Y` = add order data to thankyou URL, `N` = no order data added

## Response

```json
{
  "product_id": 12345
}
```

### Response Fields

- `product_id` (integer) - ID of the newly created product

## Usage Example

```php
use Digistore24\Request\Product\CreateProductRequest;

$request = new CreateProductRequest(
    nameIntern: 'my-awesome-product',
    nameEn: 'My Awesome Product',
    nameDe: 'Mein tolles Produkt',
    descriptionEn: '<p>A comprehensive guide to...</p>',
    salespageUrl: 'https://example.com/sales',
    thankyouUrl: 'https://example.com/thank-you',
    productTypeId: 1,
    buyerType: 'consumer',
    isAddressInputMandatory: 'N'
);

try {
    $response = $digistore24->products->create($request);
    echo "Product created with ID: " . $response->productId;
} catch (\Digistore24\Exception\ApiException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Creating a Digital Product

```php
$request = new CreateProductRequest(
    nameIntern: 'ebook-marketing-101',
    nameEn: 'E-Book: Marketing 101',
    nameDe: 'E-Book: Marketing Grundlagen',
    descriptionEn: '<p>Learn the fundamentals of digital marketing</p>',
    descriptionDe: '<p>Lernen Sie die Grundlagen des digitalen Marketings</p>',
    salespageUrl: 'https://example.com/ebook-marketing',
    thankyouUrl: 'https://example.com/download',
    imageUrl: 'https://example.com/images/ebook-cover.jpg',
    productTypeId: 1, // Digital product
    buyerType: 'consumer',
    isAddressInputMandatory: 'N', // No shipping address needed
    affiliateCommission: 50.00
);

$response = $digistore24->products->create($request);
echo "Digital product created: " . $response->productId;
```

## Creating a Physical Product

```php
$request = new CreateProductRequest(
    nameIntern: 'printed-course-materials',
    nameEn: 'Printed Course Materials',
    salespageUrl: 'https://example.com/printed-course',
    thankyouUrl: 'https://example.com/thank-you',
    productTypeId: 2, // Physical product
    buyerType: 'consumer',
    isAddressInputMandatory: 'Y', // Shipping address required
    approvalStatus: 'new'
);

$response = $digistore24->products->create($request);
echo "Physical product created: " . $response->productId;
```

## Error Handling

```php
use Digistore24\Exception\ValidationException;
use Digistore24\Exception\ForbiddenException;
use Digistore24\Exception\ApiException;

try {
    $response = $digistore24->products->create($request);
    echo "Success! Product ID: " . $response->productId;
} catch (ValidationException $e) {
    // Invalid parameters (e.g., name too long, invalid enum value)
    echo "Validation error: " . $e->getMessage();
} catch (ForbiddenException $e) {
    // Full access API key required
    echo "Access denied: " . $e->getMessage();
} catch (ApiException $e) {
    // General API error
    echo "API error: " . $e->getMessage();
}
```

## Important Notes

- **Full Access Required**: This endpoint requires a full access API key
- **Internal Name**: The `name_intern` is required and used for internal identification
- **Product Types**: Use `getGlobalSettings` to retrieve valid product type IDs
- **HTML Descriptions**: Description fields accept filtered HTML for formatting
- **Approval Status**: New products can be created as `new` or `pending` approval
- **VAT Handling**: Use `buyer_type` to control whether prices include or exclude VAT
- **Address Collection**: Set `is_address_input_mandatory` based on whether the product requires shipping

## Related Endpoints

- [getProduct](getProduct.md) - Get product details
- [listProducts](listProducts.md) - List all products
- [updateProduct](updateProduct.md) - Update product information
- [copyProduct](copyProduct.md) - Copy an existing product
- [deleteProduct](deleteProduct.md) - Delete a product
