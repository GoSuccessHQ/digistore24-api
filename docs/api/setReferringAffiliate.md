# setReferringAffiliate

Assigns a referring affiliate to a specific purchase.

## Endpoint

**POST** `https://www.digistore24.com/api/call/setReferringAffiliate`

[OpenAPI spec](https://digistore24.com/api/docs/paths/setReferringAffiliate.yaml)

## Parameters

`SetReferringAffiliateRequest` takes the following constructor arguments:

- `purchaseId` (string, required) — The purchase ID.
- `affiliateId` (string, required) — The Digistore24 ID of the affiliate to assign.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Affiliate\SetReferringAffiliateRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new SetReferringAffiliateRequest(
    purchaseId: 'ABC123XYZ',
    affiliateId: 'max_mustermann',
);

$response = $ds24->affiliates->setReferring($request);

echo $response->affiliateId;   // e.g. 789
echo $response->affiliateCode; // e.g. "max_mustermann"
echo $response->email;         // e.g. "customer@example.com"
```

## Response

`SetReferringAffiliateResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `email` (string) — The customer email.
- `affiliateId` (int|null) — The affiliate ID.
- `affiliateCode` (string|null) — Affiliate code.
- `setAt` (DateTimeInterface|null) — Timestamp when the affiliate was set.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->affiliates->setReferring($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getReferringAffiliate](getReferringAffiliate.md)
- [setAffiliateForEmail](setAffiliateForEmail.md)
- [validateAffiliate](validateAffiliate.md)
- [getAffiliateCommission](getAffiliateCommission.md)
