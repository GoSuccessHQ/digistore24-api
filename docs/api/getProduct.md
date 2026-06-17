# getProduct

Retrieves detailed information about a single product.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getProduct`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getProduct.yaml)

## Parameters

`GetProductRequest` takes the following constructor argument:

- `productId` (string, required) — ID of the product to retrieve.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\GetProductRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetProductRequest(productId: '12345');

$response = $ds24->products->get($request);

echo $response->productName; // e.g. "Online Course 2026"
echo $response->price;       // e.g. 199.0
echo $response->currency;    // e.g. "EUR"
```

## Response

`GetProductResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `productId` (string) — The product ID.
- `productName` (string) — The product name.
- `productType` (string) — The product type.
- `price` (float) — The product price.
- `currency` (string) — Currency code (defaults to `EUR`).
- `description` (string|null) — Product description, if any.
- `isPublished` (bool) — Whether the product is published.
- `imageUrl` (string|null) — URL of the product image, if any.
- `additionalData` (array) — Any further fields returned by the API, keyed by field name.

## Error Handling

```php
try {
    $response = $ds24->products->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listProducts](listProducts.md)
- [createProduct](createProduct.md)
- [updateProduct](updateProduct.md)
- [copyProduct](copyProduct.md)
- [deleteProduct](deleteProduct.md)
