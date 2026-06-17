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
    echo $group['name'];
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
- `productGroups` (array<string, mixed>) — List of product groups. Iterate and read each entry by key, e.g. `$group['name']`.

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
