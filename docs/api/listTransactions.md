# listTransactions

Retrieves a paginated and filterable list of transactions.

## Endpoint

**POST** `https://www.digistore24.com/api/call/listTransactions`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listTransactions.yaml)

## Parameters

`ListTransactionsRequest` takes the following constructor arguments:

- `from` (string, optional) — Start time, e.g. `2014-02-28 23:11:24`, `now`, `-3d`, or `start`. Defaults to `-24h`.
- `to` (string, optional) — End time. Defaults to `now`.
- `search` (`TransactionSearchData`, optional) — Search criteria for filtering. Defaults to `null`.
- `sortBy` (`TransactionSortBy`, optional) — Sort criteria: `TransactionSortBy::DATE`, `EARNING`, or `AMOUNT`. Defaults to `TransactionSortBy::DATE`.
- `sortOrder` (`SortOrder`, optional) — Sort order: `SortOrder::ASC` or `SortOrder::DESC`. Defaults to `SortOrder::ASC`.
- `pageNo` (int, optional) — Page number, starting at 1. Defaults to `1`.
- `pageSize` (int, optional) — Number of items per page. Defaults to `500`.

`TransactionSearchData` constructor arguments (all optional): `role`, `productId`, `firstName`, `lastName`, `email`, `hasAffiliate` (bool), `affiliateName`, `payMethod`, `billingType`, `transactionType` (e.g. `payment`, `refund`, `chargeback`, `refund_request`), `currency`, `purchaseId`. Comma-separated values are supported where multiple entries apply.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Transaction\ListTransactionsRequest;
use GoSuccess\Digistore24\Api\DTO\TransactionSearchData;
use GoSuccess\Digistore24\Api\Enum\TransactionSortBy;
use GoSuccess\Digistore24\Api\Enum\SortOrder;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$search = new TransactionSearchData(
    transactionType: 'payment',
    currency: 'EUR',
);

$request = new ListTransactionsRequest(
    from: '-7d',
    to: 'now',
    search: $search,
    sortBy: TransactionSortBy::DATE,
    sortOrder: SortOrder::DESC,
    pageNo: 1,
    pageSize: 100,
);

$response = $ds24->transactions->list($request);

echo $response->result; // e.g. "success"

foreach ($response->transactionList as $transaction) {
    // $transaction is an associative array of transaction fields
    echo $transaction['id'] ?? '', PHP_EOL;
}
```

The request is optional. Calling `$ds24->transactions->list()` with no arguments returns the last 24 hours using the defaults.

## Response

`ListTransactionsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `transactionList` (array) — The matching transactions, each represented as an associative array of fields. Read individual values with `$transaction['key']`.

## Error Handling

```php
try {
    $response = $ds24->transactions->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [refundTransaction](refundTransaction.md)
