# listRebillingStatusChanges

Retrieves a list of rebilling status changes within a date range.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listRebillingStatusChanges`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listRebillingStatusChanges.yaml)

## Parameters

- `from` (string, optional) — Start time for the query (e.g. `2014-02-28 23:11:24`, `now`, `-3d`, `start`). Defaults to `null` (the API uses `-24h`).
- `to` (string, optional) — End time for the query. Defaults to `null` (the API uses `now`).
- `pageNo` (int, optional) — Page number, starting at 1. Defaults to `null` (the API uses 1).
- `pageSize` (int, optional) — Number of entries per page. Defaults to `null` (the API uses 100).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Rebilling\ListRebillingStatusChangesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListRebillingStatusChangesRequest(
    from: '2026-01-01',
    to: '2026-01-31',
    pageNo: 1,
    pageSize: 50,
);

$response = $ds24->rebilling->listStatusChanges($request);

echo $response->itemCount;  // total matching items

foreach ($response->items as $change) {
    echo $change->purchaseId;        // e.g. "ABCD1234"
    echo $change->type?->value;      // e.g. "rebill_cancelled"
}
```

The request is optional. Call `$ds24->rebilling->listStatusChanges()` with no arguments to use the API defaults.

## Response

`ListRebillingStatusChangesResponse` exposes:

- `result` (string) — Result status returned by the API.
- `items` (array of `RebillingStatusChangeData`) — Status change entries (spec key `items`). Each `RebillingStatusChangeData` exposes `id` (?int), `purchaseId` (?string), `createdAt` (?DateTimeImmutable), `paySequenceNo` (?int), `type` (`?RebillingStatusChangeType`: `REBILL_CANCELLED`, `LAST_PAID_DAY`, `REBILL_RESUMED`) and `typeMsg` (?string).
- `from` (?string), `to` (?string) — The query time range echoed back.
- `pageSize` (?int), `pageNo` (?int), `pageCount` (?int), `itemCount` (?int) — Pagination metadata.

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
