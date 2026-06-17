# createVoucher

Creates a new voucher / discount code.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createVoucher`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createVoucher.yaml)

## Parameters

The request wraps a `VoucherData` DTO. Populate the following settable properties before passing it to the request:

- `code` (string, required) — The voucher code. Must not be empty and must not exceed 255 characters.
- `validFrom` (string, optional) — Point in time from when the code becomes valid. Format: `YYYY-MM-DD HH:MM:SS`.
- `expiresAt` (string, optional) — Point in time when the code becomes invalid. Format: `YYYY-MM-DD HH:MM:SS`.
- `firstRate` (float, optional) — Discount percentage on the first/single payment (0–100).
- `otherRates` (float, optional) — Discount percentage on follow-up payments (0–100).
- `firstAmount` (float, optional) — Fixed discount amount on the first/single payment (>= 0).
- `otherAmounts` (float, optional) — Fixed discount amount on follow-up payments (>= 0).
- `currency` (string, optional) — 3-letter currency code for the fixed discount amounts (e.g. `USD`, `EUR`).
- `countLeft` (int, optional) — Number of remaining uses (>= 0). Defaults to `1`.
- `upgradePolicy` (string, optional) — How the code is used for upgrades: `valid`, `other_only`, or `not_valid`. Defaults to `valid`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Voucher\CreateVoucherRequest;
use GoSuccess\Digistore24\Api\DTO\VoucherData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$voucher = new VoucherData();
$voucher->code = 'SAVE20';
$voucher->firstRate = 20.0;
$voucher->expiresAt = '2026-12-31 23:59:59';
$voucher->currency = 'EUR';

$request = new CreateVoucherRequest(voucher: $voucher);

$response = $ds24->vouchers->create($request);

echo $response->discountCodeId; // e.g. 12345
echo $response->code;           // e.g. "SAVE20"
```

## Response

`CreateVoucherResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `discountCodeId` (int) — ID of the newly created voucher.
- `code` (string) — The voucher code.

## Error Handling

```php
try {
    $response = $ds24->vouchers->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getVoucher](getVoucher.md)
- [updateVoucher](updateVoucher.md)
- [deleteVoucher](deleteVoucher.md)
- [listVouchers](listVouchers.md)
