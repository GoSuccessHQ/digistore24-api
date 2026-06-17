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

// $response->for is keyed by time bucket: all, year, quarter, month, week, day.
$thisMonth = $response->for['month'] ?? [];
echo $thisMonth['from'] ?? '';
// Amounts are nested by currency inside each bucket.
echo $thisMonth['amounts']['EUR']['total_brutto_amount'] ?? '';
```

The request is optional. Call `$ds24->statistics->salesSummary()` with no arguments to use the API defaults.

## Response

`StatsSalesSummaryResponse` exposes:

- `result` (string) — Result status returned by the API.
- `for` (array<string, mixed>) — Statistics keyed by time bucket (`all`, `year`, `quarter`, `month`, `week`, `day`). Each bucket is an associative array containing `from`, `to`, an `amounts` map keyed by currency, and the `percentages`/`references` comparison maps.
- `callDurationMs` (array<string, mixed>) — Per-section calculation durations in milliseconds (e.g. `amount_for_all`, `total_call`).
- `data` (array) — The complete inner payload, accessible by key.

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
