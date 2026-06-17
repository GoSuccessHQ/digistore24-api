# listCommissions

Returns a list of your Digistore24 commission amounts with flexible filtering by time range, transaction type, commission type, and purchase ID.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listCommissions`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listCommissions.yaml)

## Parameters

- `from` (string, optional) — Start time (e.g. `2014-02-28 23:11:24`, `now`, `-3d`, `start`).
- `to` (string, optional) — End time, in the same formats as `from`.
- `pageNo` (int, optional) — Page number for pagination (starts at 1).
- `pageSize` (int, optional) — Number of items per page (`0` returns all entries).
- `transactionType` (string, optional) — Filter by transaction types (e.g. `payment,refund,refund_request,chargeback`).
- `commissionType` (string, optional) — Filter by commission types.
- `purchaseId` (string, optional) — Filter by a specific purchase ID.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Commission\ListCommissionsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->commissions->list() works as well.
$request = new ListCommissionsRequest(
    from: '-30d',
    to: 'now',
    pageNo: 1,
    pageSize: 50,
    transactionType: 'payment,refund',
);

$response = $ds24->commissions->list($request);

echo $response->itemCount;          // e.g. 137
echo $response->getTotalAmount();   // sum of amounts on this page

foreach ($response->items as $item) {
    echo $item->amount;      // e.g. 24.90
    echo $item->currency;    // e.g. "EUR"
    echo $item->purchaseId;  // e.g. "ABCDEF12"
    echo $item->reason;      // e.g. "payment"
}

if ($response->hasMorePages()) {
    // request the next page with pageNo: 2
}
```

## Response

`ListCommissionsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `pageNo` (int) — Current page number.
- `pageSize` (int) — Number of items per page.
- `itemCount` (int) — Total number of items across all pages.
- `pageCount` (int) — Total number of pages.
- `items` (array of objects) — The commission items. Each item is a stdClass object with properties: `id` (int), `created_at` (string), `amount` (float), `currency` (string), `reason` (string), `schedule_payout_at` (string), `transaction_id` (int), and `purchase_id` (string).

The convenience methods `hasMorePages()` (returns `true` when `pageNo < pageCount`) and `getTotalAmount()` (sums the `amount` of all items on the current page) are available.

## Error Handling

```php
try {
    $response = $ds24->commissions->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listPayouts](listPayouts.md)
