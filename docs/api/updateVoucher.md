# updateVoucher

Update an existing voucher.

## Endpoint

```
POST /json/updateVoucher
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `voucher_id` | int | Yes* | Voucher ID |
| `code` | string | Yes* | Current voucher code |
| `new_code` | string | No | New voucher code |
| `discount_type` | string | No | 'percentage' or 'fixed' |
| `discount_value` | float | No | Discount value |
| `valid_from` | string | No | Start date (Y-m-d H:i:s) |
| `valid_until` | string | No | Expiration date (Y-m-d H:i:s) |
| `max_uses` | int | No | Maximum number of uses |
| `max_uses_per_buyer` | int | No | Max uses per buyer |
| `is_active` | bool | No | Active status |

*One of `voucher_id` or `code` is required to identify the voucher.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'voucher_id' => 789,
        'code' => 'AUTUMN2025',
        'discount_type' => 'percentage',
        'discount_value' => 25.0,
        'updated_at' => '2025-10-15 14:30:00'
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

// Update discount value
$response = $api->vouchers->updateVoucher(
    voucherId: 789,
    discountValue: 25.0
);

// Change voucher code
$response = $api->vouchers->updateVoucher(
    code: 'SUMMER2025',
    newCode: 'AUTUMN2025'
);

// Extend validity period
$response = $api->vouchers->updateVoucher(
    voucherId: 789,
    validUntil: '2025-12-31 23:59:59'
);

// Deactivate voucher
$response = $api->vouchers->updateVoucher(
    voucherId: 789,
    isActive: false
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Missing required fields or invalid format |
| 404 | Voucher not found | Voucher does not exist |
| 409 | Code already exists | New voucher code is already in use |
| 403 | Access denied | Not authorized to update voucher |
| 422 | Validation error | Invalid discount value or date range |

## Notes

- Only provided fields will be updated
- Use `new_code` to change the voucher code
- Cannot reduce max_uses below current usage count
- Deactivating doesn't delete usage history
- Changes are applied immediately
