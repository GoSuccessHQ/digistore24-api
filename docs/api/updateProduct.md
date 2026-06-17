# updateProduct

Updates the properties of an existing product. Only the arguments you pass are changed.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateProduct`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateProduct.yaml)

## Parameters

`UpdateProductRequest` takes the following constructor arguments:

- `productId` (int, required) — The Digistore24 product ID to update.
- `nameDe` (string, optional) — German product name (max 63 chars).
- `nameEn` (string, optional) — English product name (max 63 chars).
- `nameEs` (string, optional) — Spanish product name (max 63 chars).
- `nameIntern` (string, optional) — Internal product name (max 63 chars).
- `descriptionDe` (string, optional) — German description (filtered HTML).
- `descriptionEn` (string, optional) — English description (filtered HTML).
- `descriptionEs` (string, optional) — Spanish description (filtered HTML).
- `salespageUrl` (string, optional) — Sales page URL (max 255 chars).
- `upsellSalespageUrl` (string, optional) — Upsell sales page URL (max 255 chars).
- `thankyouUrl` (string, optional) — Thank you page URL (max 255 chars).
- `imageUrl` (string, optional) — Product image URL (max 255 chars).
- `productTypeId` (int, optional) — Product type ID (see [listProductTypes](listProductTypes.md)).
- `currency` (string, optional) — Comma-separated list of possible currencies (e.g. `"USD,EUR"`).
- `approvalStatus` (ProductApprovalStatus, optional) — Approval status: `ProductApprovalStatus::NEW` or `ProductApprovalStatus::PENDING`.
- `affiliateCommission` (float, optional) — Affiliate commission amount.
- `buyerType` (ProductBuyerType, optional) — Buyer type: `ProductBuyerType::CONSUMER` (prices include VAT) or `ProductBuyerType::BUSINESS` (prices exclude VAT).
- `isAddressInputMandatory` (bool, optional) — Whether the buyer must always enter an address.
- `addOrderDataToThankyouPageUrl` (bool, optional) — Whether order data is appended to the thank you page URL.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\UpdateProductRequest;
use GoSuccess\Digistore24\Api\Enum\ProductBuyerType;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new UpdateProductRequest(
    productId: 12345,
    nameEn: 'Online Course 2026 (Updated)',
    salespageUrl: 'https://example.com/course-v2',
    affiliateCommission: 40.0,
    buyerType: ProductBuyerType::CONSUMER,
);

$response = $ds24->products->update($request);

if ($response->wasModified()) {
    echo 'Product updated.';
} else {
    echo 'No changes were applied.';
}
```

## Response

`UpdateProductResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `modified` (string) — `"Y"` if the product was changed, `"N"` otherwise.

It also provides a helper method:

- `wasModified(): bool` — Returns `true` when `modified` equals `"Y"`.

## Error Handling

```php
try {
    $response = $ds24->products->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createProduct](createProduct.md)
- [getProduct](getProduct.md)
- [copyProduct](copyProduct.md)
- [deleteProduct](deleteProduct.md)
- [listProducts](listProducts.md)
- [listProductTypes](listProductTypes.md)
