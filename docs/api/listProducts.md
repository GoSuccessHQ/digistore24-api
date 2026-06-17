# listProducts

Lists all products in your Digistore24 account.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listProducts`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listProducts.yaml)

## Parameters

`ListProductsRequest` takes the following constructor argument:

- `sortBy` (ProductSortBy, optional) — Sort order: `ProductSortBy::NAME` (default) or `ProductSortBy::GROUP`.

The request is optional. Call `$ds24->products->list()` with no argument to list all products with the default sort order.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\ListProductsRequest;
use GoSuccess\Digistore24\Api\Enum\ProductSortBy;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// List all products, sorted by product group
$request = new ListProductsRequest(sortBy: ProductSortBy::GROUP);

$response = $ds24->products->list($request);

echo $response->totalCount; // e.g. 12

foreach ($response->products as $product) {
    echo $product->id . ': ' . $product->name . PHP_EOL;
    echo $product->productGroupName . PHP_EOL;
}
```

## Response

`ListProductsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `products` (array of `ProductListItem`) — The list of products.
- `totalCount` (int) — Number of products returned.

Each `ProductListItem` exposes many read-only typed properties, including `id` (string), `name` (string), `nameIntern` (string), `description` (string), `currency` (string), `language` (string), `productGroupId` (int), `productGroupName` (string), `productTypeId` (int), `isActive` (bool), `affiliateCommission` (string), `salespageUrl` (string), `thankyouUrl` (string), `createdAt` (?DateTimeInterface), and `modifiedAt` (?DateTimeInterface).

## Error Handling

```php
try {
    $response = $ds24->products->list($request);
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
- [deleteProduct](deleteProduct.md)
- [listProductTypes](listProductTypes.md)
