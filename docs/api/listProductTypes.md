# listProductTypes

Lists all product types available in Digistore24. Use the returned IDs when creating or updating products.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listProductTypes`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listProductTypes.yaml)

## Parameters

`ListProductTypesRequest` takes no constructor arguments.

The request is optional. Call `$ds24->products->listProductTypes()` with no argument.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->products->listProductTypes();

foreach ($response->productTypes as $type) {
    echo $type->id . ': ' . $type->name . ' (' . $type->category . ')' . PHP_EOL;
}

// Look up a single product type by ID
$type = $response->getProductTypeById(1);
if ($type !== null) {
    echo $type->name;
}
```

## Response

`ListProductTypesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `productTypes` (array of objects) — Each object has `id` (int), `name` (string), and `category` (string).

It also provides helper methods:

- `getProductTypeById(int $id): ?object` — Returns the matching product type, or `null`.
- `getProductTypesByCategory(string $category): array` — Returns all product types in a category.
- `getCategories(): array` — Returns the unique list of category names.

## Error Handling

```php
try {
    $response = $ds24->products->listProductTypes();
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createProduct](createProduct.md)
- [updateProduct](updateProduct.md)
- [getProduct](getProduct.md)
- [listProducts](listProducts.md)
