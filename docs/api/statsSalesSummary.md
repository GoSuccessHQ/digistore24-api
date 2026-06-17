# statsSalesSummary

Retrieves aggregated sales summary statistics for a date range.

## Endpoint

**GET** `https://www.digistore24.com/api/call/statsSalesSummary`

[OpenAPI spec](https://digistore24.com/api/docs/paths/statsSalesSummary.yaml)

## Parameters

- `from` (string, optional) — Start date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.
- `to` (string, optional) — End date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Statistics\StatsSalesSummaryRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StatsSalesSummaryRequest(
    from: '2026-03-01',
    to: '2026-03-31',
);

$response = $ds24->statistics->salesSummary($request);

echo $response->summary['revenue'] ?? '';
echo $response->summary['sales_count'] ?? '';
```

The request is optional. Call `$ds24->statistics->salesSummary()` with no arguments to use the API defaults.

## Response

`StatsSalesSummaryResponse` exposes:

- `result` (string) — Result status returned by the API.
- `summary` (array) — Aggregated summary values. Read values via keys, e.g. `$response->summary['revenue']`, `$response->summary['sales_count']`.

## Error Handling

```php
try {
    $response = $ds24->statistics->salesSummary($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [statsSales](statsSales.md)
- [statsDailyAmounts](statsDailyAmounts.md)
- [statsAffiliateToplist](statsAffiliateToplist.md)
