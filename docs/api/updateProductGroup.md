# updateProductGroup

Updates an existing product group's configuration.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateProductGroup`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateProductGroup.yaml)

## Parameters

- `productGroupId` (string, required) — The unique identifier of the product group to update.
- `productGroup` (`ProductGroupData`, required) — The updated product group configuration.

The `productGroup` argument wraps a `ProductGroupData` DTO with the following settable properties:

- `name` (string, required) — Product group name. Must not exceed 31 characters.
- `position` (int, optional) — The display order. Must be positive. Defaults to `10`.
- `isShownAsTab` (bool, optional) — If `true`, the group is displayed as a tab in the product list. Defaults to `false`. Sent to the API as `is_shown_as_tab` (`Y`/`N`).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ProductGroup\UpdateProductGroupRequest;
use GoSuccess\Digistore24\Api\DTO\ProductGroupData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$productGroup = new ProductGroupData();
$productGroup->name = 'Updated Premium Bundle';
$productGroup->position = 5;
$productGroup->isShownAsTab = true;

$request = new UpdateProductGroupRequest(
    productGroupId: '567',
    productGroup: $productGroup,
);

$response = $ds24->productGroups->update($request);

echo $response->result;          // e.g. "success"
var_dump($response->isModified); // bool|null — whether the group was modified
```

## Response

`UpdateProductGroupResponse` exposes:

- `result` (string) — Result status returned by the API.
- `isModified` (?bool) — Whether the product group was modified (spec key: `data.is_modified`, `Y`/`N`).
- `data` (array<string, mixed>) — Raw response payload.

## Error Handling

```php
try {
    $response = $ds24->productGroups->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createProductGroup](createProductGroup.md)
- [getProductGroup](getProductGroup.md)
- [deleteProductGroup](deleteProductGroup.md)
- [listProductGroups](listProductGroups.md)
