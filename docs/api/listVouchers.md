# listVouchers

Retrieves a list of all vouchers / discount codes.

## Endpoint

**POST** `https://www.digistore24.com/api/call/listVouchers`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listVouchers.yaml)

## Parameters

This endpoint takes no parameters. The request can be omitted entirely, in which case the resource creates one for you.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Voucher\ListVouchersRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->vouchers->list() works as well.
$response = $ds24->vouchers->list(new ListVouchersRequest());

foreach ($response->coupons as $voucher) {
    echo $voucher->code;      // e.g. "SAVE20"
    echo $voucher->firstRate; // e.g. 20.0
    echo $voucher->countLeft; // e.g. 50
}
```

## Response

`ListVouchersResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `coupons` (array of `VoucherData`) — The list of vouchers. Each item exposes readable properties such as `id`, `code`, `productIds`, `validFrom`, `expiresAt`, `firstRate`, `otherRates`, `firstAmount`, `otherAmounts`, `currency`, `isCountLimited`, `countLeft`, and `upgradePolicy`.
- `areReturnedDataPublic` (bool) — Whether the returned data is public.

## Error Handling

```php
try {
    $response = $ds24->vouchers->list(new ListVouchersRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createVoucher](createVoucher.md)
- [getVoucher](getVoucher.md)
- [updateVoucher](updateVoucher.md)
- [deleteVoucher](deleteVoucher.md)
