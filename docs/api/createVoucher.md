# createVoucher

Create a new voucher (coupon code) for products.

## Endpoint

```
POST /json/createVoucher
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `code` | string | Yes | Voucher code (unique, alphanumeric) |
| `discount_type` | string | Yes | 'percentage' or 'fixed' |
| `discount_value` | float | Yes | Discount value (percentage: 0-100, fixed: amount) |
| `currency` | string | No | Currency code (required for fixed discounts) |
| `product_ids` | array | No | Array of product IDs (empty = all products) |
| `valid_from` | string | No | Start date (Y-m-d H:i:s) |
| `valid_until` | string | No | Expiration date (Y-m-d H:i:s) |
| `max_uses` | int | No | Maximum number of uses (0 = unlimited) |
| `max_uses_per_buyer` | int | No | Max uses per buyer (0 = unlimited) |
| `minimum_order_value` | float | No | Minimum order value required |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'voucher_id' => 789,
        'code' => 'SUMMER2025',
        'discount_type' => 'percentage',
        'discount_value' => 20.0,
        'valid_from' => '2025-06-01 00:00:00',
        'valid_until' => '2025-08-31 23:59:59',
        'max_uses' => 100,
        'uses' => 0,
        'is_active' => true
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

// Create percentage discount voucher
$response = $api->vouchers->createVoucher(
    code: 'SUMMER2025',
    discountType: 'percentage',
    discountValue: 20.0,
    validFrom: '2025-06-01 00:00:00',
    validUntil: '2025-08-31 23:59:59',
    maxUses: 100
);

echo "Voucher created: {$response->code}";

// Create fixed amount discount
$response = $api->vouchers->createVoucher(
    code: 'WELCOME10',
    discountType: 'fixed',
    discountValue: 10.00,
    currency: 'EUR',
    maxUsesPerBuyer: 1,
    productIds: [123, 456] // Only for specific products
);

// Create voucher with minimum order value
$response = $api->vouchers->createVoucher(
    code: 'BIGORDER',
    discountType: 'percentage',
    discountValue: 15.0,
    minimumOrderValue: 100.00
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Missing required fields or invalid format |
| 409 | Code already exists | Voucher code is already in use |
| 422 | Validation error | Invalid discount value or date range |

## Notes

- Voucher codes must be unique across your account
- Percentage discounts: 0-100
- Fixed discounts require currency parameter
- Empty product_ids array applies voucher to all products
- Set max_uses to 0 for unlimited uses
- Valid dates are optional (no dates = always valid)
