# listRebillingStatusChanges

Retrieves a list of rebilling status changes within a date range.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listRebillingStatusChanges`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listRebillingStatusChanges.yaml)

## Parameters

- `from` (string, optional) — Start date for the range. Format: `YYYY-MM-DD`. Defaults to `null`.
- `to` (string, optional) — End date for the range. Format: `YYYY-MM-DD`. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Rebilling\ListRebillingStatusChangesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListRebillingStatusChangesRequest(
    from: '2026-01-01',
    to: '2026-01-31',
);

$response = $ds24->rebilling->listStatusChanges($request);

foreach ($response->statusChanges as $change) {
    echo $change['purchase_id'] ?? '';
    echo $change['new_status'] ?? '';
}
```

The request is optional. Call `$ds24->rebilling->listStatusChanges()` with no arguments to use the API defaults.

## Response

`ListRebillingStatusChangesResponse` exposes:

- `result` (string) — Result status returned by the API.
- `statusChanges` (array) — Status change entries. Each entry is an associative array; read values via keys, e.g. `$change['purchase_id']`, `$change['new_status']`.

## Error Handling

```php
try {
    $response = $ds24->rebilling->listStatusChanges($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [startRebilling](startRebilling.md)
- [stopRebilling](stopRebilling.md)
- [createRebillingPayment](createRebillingPayment.md)
