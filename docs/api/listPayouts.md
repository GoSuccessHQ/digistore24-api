# listPayouts

Retrieves a list of all payouts for the authenticated account.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listPayouts`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listPayouts.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely, in which case the resource creates one for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Payout\ListPayoutsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->payouts->list() works as well.
$response = $ds24->payouts->list(new ListPayoutsRequest());

echo $response->result; // e.g. "success"

foreach ($response->payoutList as $payout) {
    // Each entry is an associative array as returned by the API.
    echo $payout['amount'] ?? '';
    echo $payout['currency'] ?? '';
}
```

## Response

`ListPayoutsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `payoutList` (array) — The list of payouts. Each item is an associative array; read individual fields via `$payout['key']`.

## Error Handling

```php
try {
    $response = $ds24->payouts->list(new ListPayoutsRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [statsExpectedPayouts](statsExpectedPayouts.md)
