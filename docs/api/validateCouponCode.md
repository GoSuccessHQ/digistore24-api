# validateCouponCode

Validates a coupon or voucher code and returns its details.

## Endpoint

**GET** `https://www.digistore24.com/api/call/validateCouponCode`

[OpenAPI spec](https://digistore24.com/api/docs/paths/validateCouponCode.yaml)

## Parameters

- `code` (string, required) — The coupon or voucher code to validate.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ConversionTool\ValidateCouponCodeRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ValidateCouponCodeRequest(code: 'SAVE20');

$response = $ds24->conversionTools->validateCoupon($request);

if ($response->isValid()) {
    echo $response->couponId;    // e.g. 12345
    echo $response->amountLeft;  // e.g. 49.0
    echo $response->amountTotal; // e.g. 100.0
    echo $response->currency;    // e.g. "EUR"
} else {
    echo $response->statusMsg;   // human-readable reason
}
```

## Response

`ValidateCouponCodeResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `status` (string) — Validation status (`success` or `error`).
- `statusMsg` (string) — Human-readable status message.
- `currency` (string|null) — Currency code of the voucher.
- `couponId` (int|null) — ID of the voucher.
- `amountLeft` (float|null) — Remaining amount that can be used from this voucher.
- `amountTotal` (float|null) — Total amount of the voucher.
- `isTestPayment` (bool|null) — Whether the voucher can only be used for test payments.

The convenience method `isValid()` returns `true` when `status` equals `success`.

## Error Handling

```php
try {
    $response = $ds24->conversionTools->validateCoupon($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listConversionTools](listConversionTools.md)
