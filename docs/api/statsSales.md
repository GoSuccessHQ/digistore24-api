# statsSales

Retrieves detailed sales statistics for a specified date range.

## Endpoint

**GET** `https://www.digistore24.com/api/call/statsSales`

[OpenAPI spec](https://digistore24.com/api/docs/paths/statsSales.yaml)

## Parameters

- `from` (string, optional) — Start date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.
- `to` (string, optional) — End date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.
- `period` (`StatsPeriod`, optional) — Time period for grouping sales data: `DAY`, `WEEK`, `MONTH`, `QUARTER`, `YEAR`. Defaults to `null` (the API groups by week).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Enum\StatsPeriod;
use GoSuccess\Digistore24\Api\Request\Statistics\StatsSalesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StatsSalesRequest(
    from: '2026-03-01',
    to: '2026-03-31',
    period: StatsPeriod::MONTH,
);

$response = $ds24->statistics->sales($request);

echo $response->period?->value;  // e.g. "month"

foreach ($response->amounts as $currency => $buckets) {
    foreach ($buckets as $bucket) {
        echo $currency;                    // e.g. "EUR"
        echo $bucket->totalBruttoAmount;   // gross total for the period
    }
}
```

The request is optional. Call `$ds24->statistics->sales()` with no arguments to use the API defaults.

## Response

`StatsSalesResponse` exposes:

- `result` (string) — Result status returned by the API.
- `amounts` (array<string, array of `PeriodAmountData`>) — Revenue figures keyed by currency code; each value is the list of period buckets. Each `PeriodAmountData` exposes `from` (?string), `to` (?string) and the `vendor`/`affiliate`/`other`/`total` × `share`/`brutto`/`netto` amount fields (all ?float).
- `from` (?string) — Overall statistics start date.
- `to` (?string) — Overall statistics end date.
- `period` (`?StatsPeriod`) — Grouping period used for the buckets.
- `data` (array) — The complete inner payload, accessible by key.

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
