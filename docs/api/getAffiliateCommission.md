# getAffiliateCommission

Retrieves the affiliate commission settings for a specific affiliate and one or more products.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getAffiliateCommission`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getAffiliateCommission.yaml)

## Parameters

`GetAffiliateCommissionRequest` takes the following constructor arguments:

- `affiliateId` (string, required) — The Digistore24 ID of the affiliate.
- `productIds` (string, optional) — Product IDs, comma-separated (e.g. `"11,22,33"`), or `"all"` for every product. Defaults to `"all"`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Affiliate\GetAffiliateCommissionRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetAffiliateCommissionRequest(
    affiliateId: 'max_mustermann',
    productIds: '12345,67890',
);

$response = $ds24->affiliates->getCommission($request);

echo $response->affiliateId;   // e.g. "max_mustermann"
echo $response->affiliateName; // e.g. "Max Mustermann"

foreach ($response->affiliations as $affiliation) {
    echo $affiliation->productId;               // e.g. "12345"
    echo $affiliation->commissionRate;          // e.g. "30.00"
    echo $affiliation->approvalStatus->label(); // e.g. "Approved"
}
```

## Response

`GetAffiliateCommissionResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `affiliateId` (string) — The affiliate ID.
- `affiliateName` (string) — The affiliate name.
- `affiliations` (array of `AffiliationData`) — One entry per product. Each `AffiliationData` exposes read-only properties:
  - `commissionRate` (string) — Commission rate as a percentage.
  - `commissionCurrency` (string) — Currency code for the commission.
  - `commissionFix` (string) — Fixed commission amount.
  - `defaultCommissionRate` (string) — Default commission rate as a percentage.
  - `defaultCommissionFix` (string) — Default fixed commission amount.
  - `defaultCommissionCurrency` (string) — Default commission currency code.
  - `isOnFirstPmntOnly` (bool) — Whether the commission applies to the first payment only.
  - `productId` (string) — Product ID.
  - `productIsActive` (bool) — Whether the product is active.
  - `approvalStatus` (`AffiliateApprovalStatus`) — Approval status enum (`new`, `approved`, `rejected`, `pending`).
  - `approvalStatusMsg` (string) — Human-readable approval status message.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->affiliates->getCommission($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [updateAffiliateCommission](updateAffiliateCommission.md)
- [validateAffiliate](validateAffiliate.md)
- [getAffiliateForEmail](getAffiliateForEmail.md)
- [getReferringAffiliate](getReferringAffiliate.md)
