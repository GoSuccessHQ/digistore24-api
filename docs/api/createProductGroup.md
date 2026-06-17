# createProductGroup

Creates a new product group for organizing related products.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createProductGroup`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createProductGroup.yaml)

## Parameters

The request wraps a `ProductGroupData` DTO. Populate the following settable properties before passing it to the request:

- `name` (string, required) — Product group name. Must not exceed 31 characters.
- `position` (int, optional) — The display order. Must be positive. Defaults to `10`.
- `isShownAsTab` (bool, optional) — If `true`, the group is displayed as a tab in the product list. Defaults to `false`. Sent to the API as `is_shown_as_tab` (`Y`/`N`).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ProductGroup\CreateProductGroupRequest;
use GoSuccess\Digistore24\Api\DTO\ProductGroupData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$productGroup = new ProductGroupData();
$productGroup->name = 'Premium Bundle';
$productGroup->position = 20;
$productGroup->isShownAsTab = true;

$request = new CreateProductGroupRequest(productGroup: $productGroup);

$response = $ds24->productGroups->create($request);

echo $response->result;             // e.g. "success"
echo $response->productGroupId;     // e.g. 567
```

## Response

`CreateProductGroupResponse` exposes:

- `result` (string) — Result status returned by the API.
- `productGroupId` (?int) — ID of the newly created product group (spec key: `product_group_id`).
- `data` (array<string, mixed>) — Raw response payload. Read individual values by key, e.g. `$response->data['product_group_id']`.
- `getProductGroupId(): ?string` — Convenience accessor returning the ID as a string for backward compatibility.

## Error Handling

```php
try {
    $response = $ds24->productGroups->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getProductGroup](getProductGroup.md)
- [updateProductGroup](updateProductGroup.md)
- [deleteProductGroup](deleteProductGroup.md)
- [listProductGroups](listProductGroups.md)
