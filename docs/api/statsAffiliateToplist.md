# statsAffiliateToplist

Retrieves a ranked list of top-performing affiliates for a date range.

## Endpoint

**GET** `https://www.digistore24.com/api/call/statsAffiliateToplist`

[OpenAPI spec](https://digistore24.com/api/docs/paths/statsAffiliateToplist.yaml)

## Parameters

- `from` (string, required by the API) — Start month for the report. Format: `YYYY-MM` (e.g. `2026-01`). Defaults to `null`.
- `to` (string, required by the API) — End month for the report. Format: `YYYY-MM` (e.g. `2026-12`). Defaults to `null`.
- `affiliate` (string, optional) — Digistore identifier of a particular affiliate to filter by. Defaults to `null`.
- `currency` (string, optional) — Currency code for revenue display (`USD`, `EUR`, `GBP`, `CHF`, `PLN`). Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Statistics\StatsAffiliateToplistRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new StatsAffiliateToplistRequest(
    from: '2026-01',
    to: '2026-12',
    currency: 'EUR',
);

$response = $ds24->statistics->affiliateToplist($request);

foreach ($response->topList as $affiliate) {
    echo $affiliate->affiliateName;   // e.g. "john_doe"
    echo $affiliate->bruttoAmount;    // gross revenue
}
```

## Response

`StatsAffiliateToplistResponse` exposes:

- `result` (string) — Result status returned by the API.
- `topList` (array of `AffiliateToplistItemData`) — Ranked affiliate entries (spec key `top_list`). Each `AffiliateToplistItemData` exposes: `affiliateId` (?int), `affiliateName` (?string), `currency` (?string), `bruttoAmount` (?float), `nettoAmount` (?float), `paymentAmount` (?float), `refundAmount` (?float), `chargebackAmount` (?float), `cancellationAmount` (?float), `affiliateAmount` (?float), `merchantAmount` (?float), `refundQuota` (?float), `chargebackQuota` (?float), `cancellationQuota` (?float).

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
