# deleteProductGroup

Deletes an existing product group by its unique identifier.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteProductGroup`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteProductGroup.yaml)

## Parameters

- `productGroupId` (string, required) — The unique identifier of the product group to delete.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ProductGroup\DeleteProductGroupRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteProductGroupRequest(productGroupId: '567');

$response = $ds24->productGroups->delete($request);

echo $response->result; // e.g. "success"
```

## Response

`DeleteProductGroupResponse` exposes:

- `result` (string) — Result status returned by the API.

## Error Handling

```php
try {
    $response = $ds24->productGroups->delete($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createProductGroup](createProductGroup.md)
- [getProductGroup](getProductGroup.md)
- [updateProductGroup](updateProductGroup.md)
- [listProductGroups](listProductGroups.md)
