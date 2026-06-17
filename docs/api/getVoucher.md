# getVoucher

Retrieves the details of a single voucher by its code or ID.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getVoucher`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getVoucher.yaml)

## Parameters

- `code` (string, required) — The voucher code or ID to look up.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Voucher\GetVoucherRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetVoucherRequest(code: 'SAVE20');

$response = $ds24->vouchers->get($request);

$voucher = $response->voucher; // VoucherData|null

if ($voucher !== null) {
    echo $voucher->code;          // e.g. "SAVE20"
    echo $voucher->firstRate;     // e.g. 20.0
    echo $voucher->productIds;    // e.g. "all"
    echo $voucher->upgradePolicy; // e.g. "valid"
}
```

## Response

`GetVoucherResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `voucher` (`VoucherData`|null) — The voucher details. Useful readable properties include `id`, `code`, `productIds`, `validFrom`, `expiresAt`, `firstRate`, `otherRates`, `firstAmount`, `otherAmounts`, `currency`, `isCountLimited`, `countLeft`, and `upgradePolicy`.

## Error Handling

```php
try {
    $response = $ds24->vouchers->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createVoucher](createVoucher.md)
- [updateVoucher](updateVoucher.md)
- [deleteVoucher](deleteVoucher.md)
- [listVouchers](listVouchers.md)
