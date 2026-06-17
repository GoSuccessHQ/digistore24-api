# listPurchases

Lists all purchases/orders in the account with filtering and pagination options.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listPurchases`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listPurchases.yaml)

## Parameters

Constructor arguments of `ListPurchasesRequest` (all optional):

- `from` (string) — Start time for the list (e.g. `2026-02-28 23:11:24`, `now`, `-3d`, `start`). Defaults to `-24h`.
- `to` (string) — End time for the list. Defaults to `now`.
- `search` (`PurchaseSearchData`, optional) — Search criteria for filtering. Defaults to `null`.
- `sortBy` (`PurchaseSortBy`) — Sort criteria: `DATE`, `EARNING`, or `AMOUNT`. Defaults to `PurchaseSortBy::DATE`.
- `sortOrder` (`SortOrder`) — Sort order: `ASC` or `DESC`. Defaults to `SortOrder::ASC`.
- `loadTransactions` (bool) — Include the transaction list for each purchase. Defaults to `false`.
- `pageNo` (int) — Page number, starting at 1. Defaults to `1`.
- `pageSize` (int) — Number of items per page. Defaults to `500`.

`PurchaseSearchData` exposes these optional constructor arguments: `role`, `productId`, `firstName`, `lastName`, `email`, `hasAffiliate` (bool), `affiliateName`, `orderType` (`OrderType::LIVE` or `OrderType::TEST`), `payMethod`, `billingType`, `transactionType`, `currency`, `purchaseId`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\ListPurchasesRequest;
use GoSuccess\Digistore24\Api\DTO\PurchaseSearchData;
use GoSuccess\Digistore24\Api\Enum\PurchaseSortBy;
use GoSuccess\Digistore24\Api\Enum\SortOrder;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// List all purchases of the last 24 hours (defaults).
$response = $ds24->purchases->list();

echo $response->totalCount;

foreach ($response->purchases as $purchase) {
    echo $purchase->purchaseId;                          // e.g. "12345678"
    echo $purchase->productName;                         // e.g. "Premium Course"
    echo $purchase->amount . ' ' . $purchase->currency;  // e.g. "99 EUR"
    echo $purchase->buyerEmail;                          // e.g. "customer@example.com"
    echo $purchase->createdAt->format('Y-m-d H:i:s');
}

// Filtered example: paid orders for one product in June 2026, newest first.
$request = new ListPurchasesRequest(
    from: '2026-06-01 00:00:00',
    to: '2026-06-30 23:59:59',
    search: new PurchaseSearchData(
        productId: '987654',
        email: 'customer@example.com',
    ),
    sortBy: PurchaseSortBy::DATE,
    sortOrder: SortOrder::DESC,
    pageSize: 100,
);

$response = $ds24->purchases->list($request);
```

## Response

`ListPurchasesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `purchases` (array of `PurchaseListItem`) — The matching purchases.
- `totalCount` (int) — Total number of purchases.

Each `PurchaseListItem` exposes readonly properties: `purchaseId` (string), `productId` (string), `productName` (string), `buyerEmail` (string), `paymentStatus` (string), `amount` (float), `currency` (string), and `createdAt` (DateTimeInterface).

## Error Handling

```php
try {
    $response = $ds24->purchases->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchase](getPurchase.md)
- [listPurchasesOfEmail](listPurchasesOfEmail.md)
- [getPurchaseTracking](getPurchaseTracking.md)
- [getPurchaseDownloads](getPurchaseDownloads.md)
