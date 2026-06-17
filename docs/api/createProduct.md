# createProduct

Creates a new product in your Digistore24 account.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createProduct`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createProduct.yaml)

## Parameters

`CreateProductRequest` takes the following constructor arguments:

- `nameIntern` (string, required) — Internal product name (max 63 chars).
- `nameDe` (string, optional) — German product name (max 63 chars).
- `nameEn` (string, optional) — English product name (max 63 chars).
- `nameEs` (string, optional) — Spanish product name (max 63 chars).
- `descriptionDe` (string, optional) — German description (filtered HTML).
- `descriptionEn` (string, optional) — English description (filtered HTML).
- `descriptionEs` (string, optional) — Spanish description (filtered HTML).
- `salespageUrl` (string, optional) — Sales page URL (max 255 chars).
- `upsellSalespageUrl` (string, optional) — Upsell sales page URL (max 255 chars).
- `thankyouUrl` (string, optional) — Thank you page URL (max 255 chars).
- `imageUrl` (string, optional) — Product image URL (max 255 chars).
- `productTypeId` (int, optional) — Product type ID (see [listProductTypes](listProductTypes.md)).
- `approvalStatus` (ProductApprovalStatus, optional) — Approval status: `ProductApprovalStatus::NEW` or `ProductApprovalStatus::PENDING`.
- `affiliateCommission` (float, optional) — Affiliate commission amount.
- `buyerType` (ProductBuyerType, optional) — Buyer type: `ProductBuyerType::CONSUMER` (prices include VAT) or `ProductBuyerType::BUSINESS` (prices exclude VAT).
- `isAddressInputMandatory` (bool, optional) — Whether the buyer must always enter an address.
- `addOrderDataToThankyouPageUrl` (bool, optional) — Whether order data is appended to the thank you page URL.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Product\CreateProductRequest;
use GoSuccess\Digistore24\Api\Enum\ProductApprovalStatus;
use GoSuccess\Digistore24\Api\Enum\ProductBuyerType;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new CreateProductRequest(
    nameIntern: 'Online Course 2026',
    nameEn: 'Online Course 2026',
    descriptionEn: '<p>Lifetime access to all course modules.</p>',
    salespageUrl: 'https://example.com/course',
    thankyouUrl: 'https://example.com/thank-you',
    productTypeId: 1,
    approvalStatus: ProductApprovalStatus::NEW,
    affiliateCommission: 30.0,
    buyerType: ProductBuyerType::CONSUMER,
);

$response = $ds24->products->create($request);

echo $response->productId; // e.g. 12345
```

## Response

`CreateProductResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `productId` (int) — ID of the newly created product.

## Error Handling

```php
try {
    $response = $ds24->products->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getProduct](getProduct.md)
- [updateProduct](updateProduct.md)
- [copyProduct](copyProduct.md)
- [deleteProduct](deleteProduct.md)
- [listProducts](listProducts.md)
- [listProductTypes](listProductTypes.md)
