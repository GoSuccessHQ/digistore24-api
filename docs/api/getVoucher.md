# getVoucher

Get details of a specific voucher.

## Endpoint

```
POST /json/getVoucher
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `voucher_id` | int | Yes* | Voucher ID |
| `code` | string | Yes* | Voucher code |

*One of `voucher_id` or `code` is required.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'voucher_id' => 789,
        'code' => 'SUMMER2025',
        'discount_type' => 'percentage',
        'discount_value' => 20.0,
        'currency' => null,
        'product_ids' => [123, 456],
        'valid_from' => '2025-06-01 00:00:00',
        'valid_until' => '2025-08-31 23:59:59',
        'max_uses' => 100,
        'uses' => 45,
        'max_uses_per_buyer' => 1,
        'minimum_order_value' => 0.00,
        'is_active' => true,
        'created_at' => '2025-05-15 10:00:00'
    ]
]
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Get voucher by code
$response = $api->vouchers->getVoucher(
    code: 'SUMMER2025'
);

echo "Voucher: {$response->code}";
echo "Discount: {$response->discountValue}%";
echo "Uses: {$response->uses}/{$response->maxUses}";

// Get voucher by ID
$response = $api->vouchers->getVoucher(
    voucherId: 789
);

if ($response->isActive) {
    echo "Voucher is currently active";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Missing parameter | Neither voucher_id nor code provided |
| 404 | Voucher not found | Voucher does not exist |
| 403 | Access denied | Not authorized to access this voucher |

## Notes

- Returns all voucher details including usage statistics
- Use `code` for customer-facing validations
- Use `voucher_id` for administrative tasks
- Check `is_active` and date range for validity
