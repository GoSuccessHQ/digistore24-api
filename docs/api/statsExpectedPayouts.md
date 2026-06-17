# statsExpectedPayouts

Retrieves statistics about expected upcoming payouts.

## Endpoint

**GET** `https://www.digistore24.com/api/call/statsExpectedPayouts`

[OpenAPI spec](https://digistore24.com/api/docs/paths/statsExpectedPayouts.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely, in which case the resource creates one for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Payout\StatsExpectedPayoutsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->payouts->statsExpected() works as well.
$response = $ds24->payouts->statsExpected(new StatsExpectedPayoutsRequest());

echo $response->result; // e.g. "success"

// The statistics payload is returned as an associative array.
$amount = $response->data['amount'] ?? null;
$currency = $response->data['currency'] ?? null;
```

## Response

`StatsExpectedPayoutsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `data` (array) — The expected payout statistics as an associative array; read individual fields via `$response->data['key']`.

## Error Handling

```php
try {
    $response = $ds24->payouts->statsExpected(new StatsExpectedPayoutsRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listPayouts](listPayouts.md)
