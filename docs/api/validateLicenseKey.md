# validateLicenseKey

Validates a license key against a purchase and returns detailed information about the license status.

## Endpoint

**GET** `https://www.digistore24.com/api/call/validateLicenseKey`

[OpenAPI spec](https://digistore24.com/api/docs/paths/validateLicenseKey.yaml)

## Parameters

- `purchaseId` (string, required) — The purchase ID to validate against.
- `licenseKey` (string, required) — The license key to validate.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\License\ValidateLicenseKeyRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ValidateLicenseKeyRequest(
    purchaseId: 'ABCDEF12',
    licenseKey: 'XXXX-YYYY-ZZZZ',
);

$response = $ds24->licenses->validate($request);

if ($response->isValid()) {
    echo $response->productName;   // e.g. "Premium Plan"
    echo $response->billingStatus; // e.g. "paying"
    echo $response->paidUntil;     // e.g. "2026-12-31"
} elseif (! $response->isFound()) {
    echo 'License key not found.';
}
```

## Response

`ValidateLicenseKeyResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `isLicenseValid` (string) — `Y` if the license is valid, otherwise `N`.
- `isLicenseKeyFound` (string) — `Y` if the license key was found, otherwise `N`.
- `purchaseId` (string) — The purchase ID.
- `licenseKey` (string) — The license key.
- `productId` (int) — The product ID.
- `productName` (string) — The product name.
- `billingStatus` (string) — The billing status.
- `billingStatusMsg` (string) — Human-readable billing status message.
- `lastPaymentAt` (string|null) — Date of the last payment.
- `lastPaymentAtMsg` (string|null) — Human-readable last payment date.
- `nextPaymentAt` (string|null) — Date of the next scheduled payment.
- `nextPaymentAtMsg` (string|null) — Human-readable next payment date.
- `lastTransactionType` (string|null) — Type of the last transaction.
- `lastTransactionTypeMsg` (string|null) — Human-readable last transaction type.
- `paidUntil` (string|null) — Date until which the product is paid.
- `paidUntilMsg` (string|null) — Human-readable paid-until date.

The convenience methods `isValid()` (returns `true` when `isLicenseValid` is `Y`) and `isFound()` (returns `true` when `isLicenseKeyFound` is `Y`) are available.

## Error Handling

```php
try {
    $response = $ds24->licenses->validate($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [validateCouponCode](validateCouponCode.md)
