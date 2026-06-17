# validateCouponCode

Validate a coupon/voucher code for a product.

## Endpoint

```
POST /json/validateCouponCode
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `code` | string | Yes | Coupon/voucher code |
| `product_id` | int | No | Product ID to validate against |
| `cart_amount` | float | No | Cart amount for minimum order validation |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'valid' => true,
        'code' => 'SUMMER2025',
        'voucher_id' => 789,
        'discount_type' => 'percentage',
        'discount_value' => 20.0,
        'applicable' => true,
        'minimum_order_value' => 0.00,
        'valid_until' => '2025-08-31 23:59:59',
        'uses_remaining' => 50,
        'message' => '20% discount applied'
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

// Validate coupon code
$response = $api->conversionTools->validateCouponCode(
    code: 'SUMMER2025',
    productId: 12345,
    cartAmount: 150.00
);

if ($response->valid && $response->applicable) {
    echo "Valid! {$response->message}\n";
    echo "Discount: {$response->discountValue}%\n";
} else {
    echo "Invalid or not applicable\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | Code not found | Coupon code does not exist |
| 410 | Code expired | Coupon has expired |
| 422 | Not applicable | Code not valid for this product/amount |

## Notes

- Returns validation details even if code is invalid
- Check both `valid` and `applicable` flags
- `applicable` checks product and minimum order requirements
- `uses_remaining` shows how many times code can still be used
- Useful for real-time coupon validation in checkout
