# getReferringAffiliate

Retrieves the referring affiliate for a specific purchase.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getReferringAffiliate`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getReferringAffiliate.yaml)

## Parameters

`GetReferringAffiliateRequest` takes the following constructor argument:

- `purchaseId` (string, required) — The purchase ID to look up.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Affiliate\GetReferringAffiliateRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetReferringAffiliateRequest(purchaseId: 'ABC123XYZ');

$response = $ds24->affiliates->getReferring($request);

if ($response->affiliateId !== null) {
    echo $response->affiliateName;     // e.g. "Max Mustermann"
    echo $response->commissionEarned;  // e.g. 50.0
}
```

## Response

`GetReferringAffiliateResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `affiliateId` (int|null) — The affiliate ID.
- `affiliateCode` (string|null) — Affiliate code.
- `affiliateEmail` (string|null) — Affiliate email.
- `affiliateName` (string|null) — Affiliate name.
- `referralDate` (DateTimeInterface|null) — Date of the referral.
- `commissionEarned` (float|null) — Commission earned on the purchase.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->affiliates->getReferring($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [setReferringAffiliate](setReferringAffiliate.md)
- [getAffiliateForEmail](getAffiliateForEmail.md)
- [getAffiliateCommission](getAffiliateCommission.md)
- [validateAffiliate](validateAffiliate.md)
