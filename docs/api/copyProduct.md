# copyProduct

Creates a copy of an existing product, optionally overriding selected properties.

## Endpoint

**POST** `https://www.digistore24.com/api/call/copyProduct`

[OpenAPI spec](https://digistore24.com/api/docs/paths/copyProduct.yaml)

## Parameters

`CopyProductRequest` takes the following constructor arguments:

- `productId` (int, required) — ID of the product to be copied.
- `nameIntern` (string, optional) — Internal name for the copy (max 63 chars).
- `productTypeId` (int, optional) — Product type ID (see [listProductTypes](listProductTypes.md)).
- `language` (string, optional) — Comma-separated list of languages (e.g. `"en,de"`).
- `isActive` (bool, optional) — Activation status of the copy.
- `productGroupId` (int, optional) — Product group ID to assign the copy to.
- `nameDe` (string, optional) — German name for the copy (max 63 chars).
- `nameEn` (string, optional) — English name for the copy (max 63 chars).
- `nameEs` (string, optional) — Spanish name for the copy (max 63 chars).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\CopyProductRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new CopyProductRequest(
    productId: 12345,
    nameIntern: 'Online Course 2026 (Copy)',
    nameEn: 'Online Course 2026 - Edition B',
    language: 'en,de',
    isActive: false,
);

$response = $ds24->products->copy($request);

echo $response->productId; // e.g. 67890
```

## Response

`CopyProductResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `productId` (int) — ID of the newly created product copy.

## Error Handling

```php
try {
    $response = $ds24->products->copy($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createProduct](createProduct.md)
- [getProduct](getProduct.md)
- [updateProduct](updateProduct.md)
- [deleteProduct](deleteProduct.md)
- [listProducts](listProducts.md)
