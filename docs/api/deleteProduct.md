# deleteProduct

Permanently deletes a product. This operation cannot be undone.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteProduct`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteProduct.yaml)

## Parameters

`DeleteProductRequest` takes the following constructor argument:

- `productId` (int, required) — ID of the product to delete.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\DeleteProductRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteProductRequest(productId: 12345);

$response = $ds24->products->delete($request);

if ($response->success) {
    echo 'Product deleted.';
}
```

## Response

`DeleteProductResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `success` (bool) — `true` when the delete call completed without an API error.

## Error Handling

```php
try {
    $response = $ds24->products->delete($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getProduct](getProduct.md)
- [createProduct](createProduct.md)
- [updateProduct](updateProduct.md)
- [copyProduct](copyProduct.md)
- [listProducts](listProducts.md)
