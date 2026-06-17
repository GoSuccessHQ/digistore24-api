# deleteVoucher

Deletes a voucher identified by its code.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteVoucher`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteVoucher.yaml)

## Parameters

- `code` (string, required) — The voucher code to delete.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Voucher\DeleteVoucherRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteVoucherRequest(code: 'SAVE20');

$response = $ds24->vouchers->delete($request);

echo $response->result; // e.g. "success"
```

## Response

`DeleteVoucherResponse` exposes a typed public property:

- `result` (string) — Result of the delete operation.

## Error Handling

```php
try {
    $response = $ds24->vouchers->delete($request);
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
- [listVouchers](listVouchers.md)
