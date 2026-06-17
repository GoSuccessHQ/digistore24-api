# updateVoucher

Updates the configuration of an existing voucher, identified by its code.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateVoucher`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateVoucher.yaml)

## Parameters

- `code` (string, required) — The code of the voucher to update.
- `voucher` (`VoucherData`, required) — The updated voucher data.

Populate the following settable properties on the `VoucherData` DTO:

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
use GoSuccess\Digistore24\Api\Request\Voucher\UpdateVoucherRequest;
use GoSuccess\Digistore24\Api\DTO\VoucherData;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$voucher = new VoucherData();
$voucher->code = 'SAVE20';
$voucher->firstRate = 25.0;
$voucher->expiresAt = '2026-12-31 23:59:59';

$request = new UpdateVoucherRequest(code: 'SAVE20', voucher: $voucher);

$response = $ds24->vouchers->update($request);

echo $response->discountCodeId;        // e.g. 12345
echo $response->code;                  // e.g. "SAVE20"
var_dump($response->isModified);       // bool
```

## Response

`UpdateVoucherResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `discountCodeId` (int) — ID of the updated voucher.
- `code` (string) — The voucher code.
- `isModified` (bool) — Whether the voucher was actually modified.

## Error Handling

```php
try {
    $response = $ds24->vouchers->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createVoucher](createVoucher.md)
- [getVoucher](getVoucher.md)
- [deleteVoucher](deleteVoucher.md)
- [listVouchers](listVouchers.md)
