# statsSales

Retrieves detailed sales statistics for a specified date range.

## Endpoint

**GET** `https://www.digistore24.com/api/call/statsSales`

[OpenAPI spec](https://digistore24.com/api/docs/paths/statsSales.yaml)

## Parameters

- `from` (string, optional) — Start date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.
- `to` (string, optional) — End date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Statistics\StatsSalesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StatsSalesRequest(
    from: '2026-03-01',
    to: '2026-03-31',
);

$response = $ds24->statistics->sales($request);

foreach ($response->sales as $entry) {
    echo $entry['period'] ?? '';
    echo $entry['revenue'] ?? '';
}
```

The request is optional. Call `$ds24->statistics->sales()` with no arguments to use the API defaults.

## Response

`StatsSalesResponse` exposes:

- `result` (string) — Result status returned by the API.
- `sales` (array) — Sales entries. Each entry is an associative array; read values via keys, e.g. `$entry['period']`, `$entry['revenue']`.

## Error Handling

```php
try {
    $response = $ds24->statistics->sales($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [statsSalesSummary](statsSalesSummary.md)
- [statsDailyAmounts](statsDailyAmounts.md)
- [statsAffiliateToplist](statsAffiliateToplist.md)
