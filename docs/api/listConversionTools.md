# listConversionTools

Retrieves a list of conversion tools (such as vouchers or coupons) by type.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listConversionTools`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listConversionTools.yaml)

## Parameters

- `type` (string, required) — The conversion tool type to list (e.g. `voucher`, `coupon`).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\ConversionTool\ListConversionToolsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListConversionToolsRequest(type: 'voucher');

$response = $ds24->conversionTools->list($request);

echo $response->result; // e.g. "success"

foreach ($response->smartupgrades as $tool) {
    // Each entry is an associative array as returned by the API.
    echo $tool['id'] ?? '';
    echo $tool['name'] ?? '';
}
```

## Response

`ListConversionToolsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `smartupgrades` (array) — The list of conversion tools. Each item is an associative array; read individual fields via `$tool['key']`.

## Error Handling

```php
try {
    $response = $ds24->conversionTools->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [validateCouponCode](validateCouponCode.md)
