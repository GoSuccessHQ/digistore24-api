# validateAffiliate

Checks whether there is an affiliation for an affiliate and one or more products. Returns the same information shown when setting up an order form.

## Endpoint

**GET** `https://www.digistore24.com/api/call/validateAffiliate`

[OpenAPI spec](https://digistore24.com/api/docs/paths/validateAffiliate.yaml)

## Parameters

`ValidateAffiliateRequest` takes the following constructor arguments:

- `affiliateName` (string, required) — The Digistore24 ID of the affiliate.
- `productIds` (string, required) — One or more product IDs, separated by commas (e.g. `"11,22,33,44"`).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Affiliate\ValidateAffiliateRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ValidateAffiliateRequest(
    affiliateName: 'max_mustermann',
    productIds: '12345,67890',
);

$response = $ds24->affiliates->validate($request);

if ($response->valid && $response->isActive) {
    echo $response->name;  // e.g. "Max Mustermann"
    echo $response->email; // e.g. "affiliate@example.com"
}
```

## Response

`ValidateAffiliateResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `valid` (bool) — Whether the affiliate is valid.
- `affiliateId` (int|null) — The affiliate ID.
- `affiliateCode` (string|null) — Affiliate code.
- `isActive` (bool) — Whether the affiliate is active.
- `email` (string|null) — Affiliate email.
- `name` (string|null) — Affiliate name.

## Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Exception\ApiException;

try {
    $response = $ds24->affiliates->validate($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getAffiliateCommission](getAffiliateCommission.md)
- [getAffiliateForEmail](getAffiliateForEmail.md)
- [getReferringAffiliate](getReferringAffiliate.md)
- [setAffiliateForEmail](setAffiliateForEmail.md)
