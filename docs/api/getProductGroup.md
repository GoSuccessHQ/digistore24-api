# getProductGroup

Retrieves detailed information about a specific product group.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getProductGroup`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getProductGroup.yaml)

## Parameters

- `productGroupId` (string, required) — The unique identifier of the product group.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ProductGroup\GetProductGroupRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetProductGroupRequest(productGroupId: '567');

$response = $ds24->productGroups->get($request);

echo $response->result;                 // e.g. "success"
echo $response->productGroup['name'];   // e.g. "Premium Bundle"
```

## Response

`GetProductGroupResponse` exposes:

- `result` (string) — Result status returned by the API.
- `productGroup` (array<string, mixed>) — The product group details. Read individual values by key, e.g. `$response->productGroup['name']`.

## Error Handling

```php
try {
    $response = $ds24->productGroups->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createProductGroup](createProductGroup.md)
- [updateProductGroup](updateProductGroup.md)
- [deleteProductGroup](deleteProductGroup.md)
- [listProductGroups](listProductGroups.md)
