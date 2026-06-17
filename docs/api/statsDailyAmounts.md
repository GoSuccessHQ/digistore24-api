# statsDailyAmounts

Retrieves daily revenue amounts for a specified date range.

## Endpoint

**GET** `https://www.digistore24.com/api/call/statsDailyAmounts`

[OpenAPI spec](https://digistore24.com/api/docs/paths/statsDailyAmounts.yaml)

## Parameters

- `from` (string, optional) — Start date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.
- `to` (string, optional) — End date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Statistics\StatsDailyAmountsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StatsDailyAmountsRequest(
    from: '2026-03-01',
    to: '2026-03-31',
);

$response = $ds24->statistics->dailyAmounts($request);

foreach ($response->dailyAmounts as $day) {
    echo $day['date'] ?? '';
    echo $day['amount'] ?? '';
}
```

The request is optional. Call `$ds24->statistics->dailyAmounts()` with no arguments to use the API defaults.

## Response

`StatsDailyAmountsResponse` exposes:

- `result` (string) — Result status returned by the API.
- `dailyAmounts` (array) — Daily revenue entries. Each entry is an associative array; read values via keys, e.g. `$day['date']`, `$day['amount']`.

## Error Handling

```php
try {
    $response = $ds24->statistics->dailyAmounts($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [statsSales](statsSales.md)
- [statsSalesSummary](statsSalesSummary.md)
- [statsAffiliateToplist](statsAffiliateToplist.md)
