# setAffiliateForEmail

Assigns an affiliate to a specific email address.

## Endpoint

**POST** `https://www.digistore24.com/api/call/setAffiliateForEmail`

[OpenAPI spec](https://digistore24.com/api/docs/paths/setAffiliateForEmail.yaml)

## Parameters

`SetAffiliateForEmailRequest` takes the following constructor arguments:

- `email` (string, required) — The email address.
- `affiliateId` (string, required) — The Digistore24 ID of the affiliate to assign.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Affiliate\SetAffiliateForEmailRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new SetAffiliateForEmailRequest(
    email: 'customer@example.com',
    affiliateId: 'max_mustermann',
);

$response = $ds24->affiliates->setForEmail($request);

echo $response->affiliateId;   // e.g. 789
echo $response->affiliateCode; // e.g. "max_mustermann"
echo $response->email;         // e.g. "customer@example.com"
```

## Response

`SetAffiliateForEmailResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `affiliateId` (int|null) — The affiliate ID.
- `email` (string) — The email address.
- `firstName` (string|null) — First name.
- `lastName` (string|null) — Last name.
- `affiliateCode` (string|null) — Affiliate code.
- `isActive` (bool) — Whether the affiliate is active.
- `createdAt` (DateTimeInterface|null) — Creation timestamp.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->affiliates->setForEmail($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getAffiliateForEmail](getAffiliateForEmail.md)
- [setReferringAffiliate](setReferringAffiliate.md)
- [validateAffiliate](validateAffiliate.md)
- [updateAffiliateCommission](updateAffiliateCommission.md)
