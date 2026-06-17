# getMarketplaceEntry

Retrieves detailed information and statistics about a specific marketplace entry.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getMarketplaceEntry`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getMarketplaceEntry.yaml)

## Parameters

The request takes a single scalar constructor argument:

- `entryId` (string, required) — The unique identifier of the marketplace entry to retrieve.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Marketplace\GetMarketplaceEntryRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetMarketplaceEntryRequest(entryId: '12345');

$response = $ds24->marketplace->get($request);

echo $response->headline;        // e.g. "Premium Online Course"
echo $response->price;           // e.g. 99.0
echo $response->currency;        // e.g. "EUR"
echo $response->statsStars;      // e.g. 4.5
echo $response->statsCountOrders;// e.g. 450
```

## Response

`GetMarketplaceEntryResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `id` (int|null) — Marketplace entry ID.
- `mainProductId` (int|null) — ID of the main product.
- `allProductIds` (list<int>) — IDs of all products in the entry.
- `approvalStatus` (string|null) — Approval status of the entry.
- `approvalStatusMsg` (string|null) — Human-readable approval status message.
- `price` (float|null) — Price of the product.
- `currency` (string|null) — Currency code for the price.
- `priceMsg` (string|null) — Formatted price message.
- `language` (string|null) — Language of the entry.
- `isPriceMsgOverriden` (bool|null) — Whether the price message is overridden.
- `productCategoryId` (int|null) — Category ID.
- `productCategory` (string|null) — Category name.
- `headline` (string|null) — Entry headline.
- `description` (string|null) — Entry description.
- `affiliateShare` (float|null) — Affiliate commission share.
- `productCreatedAt` (DateTimeImmutable|null) — When the product was created.
- `statsIsValid` (bool|null) — Whether the statistics are valid.
- `statsUpdatedAt` (DateTimeImmutable|null) — When the statistics were last updated.
- `statsSellerRank` (int|null) — Seller rank.
- `statsSellerRankCategory` (int|null) — Seller rank within the category.
- `statsStars` (float|null) — Average star rating.
- `statsAffiliateProfitVisitor` (float|null) — Affiliate profit per visitor.
- `statsAffiliateProfitSale` (float|null) — Affiliate profit per sale.
- `statsCountOrdersWAff` (int|null) — Number of orders with affiliates.
- `statsCancelRate` (float|null) — Cancellation rate.
- `statsRevenue` (float|null) — Total revenue.
- `statsCountAffiliatesWithSales` (int|null) — Number of affiliates with sales.
- `statsConversionRate` (float|null) — Conversion rate.
- `statsCountOrders` (int|null) — Total number of orders.

## Error Handling

```php
try {
    $response = $ds24->marketplace->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listMarketplaceEntries](listMarketplaceEntries.md)
- [statsMarketplace](statsMarketplace.md)
