# listMarketplaceEntries

Retrieves a list of all marketplace entries.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listMarketplaceEntries`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listMarketplaceEntries.yaml)

## Parameters

This endpoint takes no parameters. The `ListMarketplaceEntriesRequest` constructor accepts no arguments, and the resource builds one for you when none is supplied.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->marketplace->list();

echo $response->result; // e.g. "success"

foreach ($response->entries as $entry) {
    // each $entry is an associative array of marketplace entry fields
}
```

## Response

`ListMarketplaceEntriesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `entries` (array) — The list of marketplace entries. Read as `$response->entries`.

## Error Handling

```php
try {
    $response = $ds24->marketplace->list();
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getMarketplaceEntry](getMarketplaceEntry.md)
- [statsMarketplace](statsMarketplace.md)
