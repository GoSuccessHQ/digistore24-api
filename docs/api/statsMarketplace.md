# statsMarketplace

Retrieves marketplace statistics, optionally for a specific language.

## Endpoint

**GET** `https://www.digistore24.com/api/call/statsMarketplace`

[OpenAPI spec](https://digistore24.com/api/docs/paths/statsMarketplace.yaml)

## Parameters

The constructor argument is optional:

- `language` (string, optional) — Language code (e.g. `de`). See `getGlobalSettings` for the list of languages.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Marketplace\StatsMarketplaceRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StatsMarketplaceRequest(language: 'de');

$response = $ds24->marketplace->stats($request);

echo $response->result; // e.g. "success"

// Statistics are returned as an associative array
foreach ($response->data as $key => $value) {
    // inspect the marketplace statistics
}
```

## Response

`StatsMarketplaceResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `data` (array) — The marketplace statistics. Read as `$response->data['key']`.

## Error Handling

```php
try {
    $response = $ds24->marketplace->stats($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getMarketplaceEntry](getMarketplaceEntry.md)
- [listMarketplaceEntries](listMarketplaceEntries.md)
