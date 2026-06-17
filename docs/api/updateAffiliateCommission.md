# updateAffiliateCommission

Updates the affiliate commission settings for a specific affiliate and product.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateAffiliateCommission`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateAffiliateCommission.yaml)

## Parameters

`UpdateAffiliateCommissionRequest` takes the following constructor arguments:

- `productId` (int, required) — The product ID the commission applies to.
- `affiliateId` (string, required) — The Digistore24 ID of the affiliate.
- `commission` (`AffiliateCommissionData`, required) — The commission settings. Populate the following settable properties:
  - `commissionRate` (float, optional) — Commission percentage. Must be between 0 and 100.
  - `commissionFix` (float, optional) — Fixed commission amount in the specified currency. Must be >= 0.
  - `commissionCurrency` (string, optional) — 3-letter currency code for the fixed commission (e.g. `USD`, `EUR`). Stored uppercase.
  - `approvalStatus` (`AffiliateApprovalStatus`, optional) — Approval status of the affiliation: `AffiliateApprovalStatus::NEW`, `APPROVED`, `REJECTED`, or `PENDING`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Affiliate\UpdateAffiliateCommissionRequest;
use GoSuccess\Digistore24\Api\DTO\AffiliateCommissionData;
use GoSuccess\Digistore24\Api\Enum\AffiliateApprovalStatus;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$commission = new AffiliateCommissionData();
$commission->commissionRate = 35.0;
$commission->commissionCurrency = 'EUR';
$commission->approvalStatus = AffiliateApprovalStatus::APPROVED;

$request = new UpdateAffiliateCommissionRequest(
    productId: 12345,
    affiliateId: 'max_mustermann',
    commission: $commission,
);

$response = $ds24->affiliates->updateCommission($request);

echo $response->productId;      // e.g. 12345
echo $response->commissionRate; // e.g. 35.0
```

## Response

`UpdateAffiliateCommissionResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `productId` (int) — The product ID.
- `commissionRate` (float|null) — Commission rate (percentage).
- `firstLevelCommission` (float|null) — First level commission rate.
- `secondLevelCommission` (float|null) — Second level commission rate.
- `isAffiliateEnabled` (bool) — Whether the affiliate program is enabled.
- `updatedAt` (DateTimeInterface|null) — Timestamp of the update.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->affiliates->updateCommission($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

Note: assigning an out-of-range value to the DTO (for example `commissionRate = 150.0`) throws an `\InvalidArgumentException` immediately, before the request is sent.

## Related Endpoints

- [getAffiliateCommission](getAffiliateCommission.md)
- [validateAffiliate](validateAffiliate.md)
- [getAffiliateForEmail](getAffiliateForEmail.md)
- [setAffiliateForEmail](setAffiliateForEmail.md)
