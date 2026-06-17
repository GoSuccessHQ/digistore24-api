# listProductGroups

Retrieves a list of all product groups.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listProductGroups`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listProductGroups.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->productGroups->list();

echo $response->result; // e.g. "success"

foreach ($response->productGroups as $group) {
    echo $group->id;     // product group ID
    echo $group->name;   // product group name
    echo $group->createdAt?->format('Y-m-d H:i:s');
    echo $group->modifiedAt?->format('Y-m-d H:i:s');
}
```

You may also pass an explicit `ListProductGroupsRequest`:

```php
use GoSuccess\Digistore24\Api\Request\ProductGroup\ListProductGroupsRequest;

$response = $ds24->productGroups->list(new ListProductGroupsRequest());
```

## Response

`ListProductGroupsResponse` exposes:

- `result` (string) — Result status returned by the API.
- `productGroups` (array<int, ProductGroupListItemData>) — List of product groups as typed DTOs.

Each `ProductGroupListItemData` exposes:

- `id` (?int) — Product group ID.
- `name` (?string) — Product group name.
- `createdAt` (?DateTimeImmutable) — Creation timestamp.
- `modifiedAt` (?DateTimeImmutable) — Last modification timestamp.

## Error Handling

```php
try {
    $response = $ds24->productGroups->list();
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
- [deleteProductGroup](deleteProductGroup.md)
