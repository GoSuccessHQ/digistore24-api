# statsAffiliateToplist

Retrieves a ranked list of top-performing affiliates for a date range.

## Endpoint

**GET** `https://www.digistore24.com/api/call/statsAffiliateToplist`

[OpenAPI spec](https://digistore24.com/api/docs/paths/statsAffiliateToplist.yaml)

## Parameters

- `from` (string, optional) — Start date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.
- `to` (string, optional) — End date for statistics. Format: `YYYY-MM-DD`. Defaults to `null`.
- `limit` (int, optional) — Maximum number of affiliates to return. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Statistics\StatsAffiliateToplistRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StatsAffiliateToplistRequest(
    from: '2026-01-01',
    to: '2026-01-31',
    limit: 10,
);

$response = $ds24->statistics->affiliateToplist($request);

foreach ($response->toplist as $affiliate) {
    echo $affiliate['name'] ?? '';
}
```

The request is optional. Call `$ds24->statistics->affiliateToplist()` with no arguments to retrieve the default toplist.

## Response

`StatsAffiliateToplistResponse` exposes:

- `result` (string) — Result status returned by the API.
- `toplist` (array) — Ranked affiliate entries. Each entry is an associative array; read values via keys, e.g. `$affiliate['name']`, `$affiliate['turnover']`.

## Error Handling

```php
try {
    $response = $ds24->statistics->affiliateToplist($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [statsSales](statsSales.md)
- [statsSalesSummary](statsSalesSummary.md)
- [statsDailyAmounts](statsDailyAmounts.md)
