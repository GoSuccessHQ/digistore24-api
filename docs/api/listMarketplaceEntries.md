# listMarketplaceEntries

Retrieves a list of all marketplace entries.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listMarketplaceEntries`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listMarketplaceEntries.yaml)

## Parameters

The constructor argument is optional:

- `sortBy` (string, optional) — Sorting criteria for the marketplace entries.

When called without a request, the resource builds an empty `ListMarketplaceEntriesRequest` for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Marketplace\ListMarketplaceEntriesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->marketplace->list();

// Or with sorting
$response = $ds24->marketplace->list(new ListMarketplaceEntriesRequest(sortBy: 'stats_stars'));

echo $response->result; // e.g. "success"

foreach ($response->entries as $entry) {
    // each $entry is a MarketplaceEntryData DTO
    echo $entry->id, ' ', $entry->headline, ' ', $entry->statsStars, PHP_EOL;
}
```

## Response

`ListMarketplaceEntriesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `entries` (`MarketplaceEntryData[]`) — The list of marketplace entries, each a typed DTO.

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
