# updateAffiliateCommission

Update affiliate commission settings for a product.

## Endpoint

```
POST /json/updateAffiliateCommission
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | Yes | Product ID |
| `commission_rate` | float | No | Commission rate (percentage) |
| `first_level_commission` | float | No | First level commission rate |
| `second_level_commission` | float | No | Second level commission rate |
| `is_affiliate_enabled` | bool | No | Enable/disable affiliate program |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'product_id' => 12345,
        'commission_rate' => 60.0,
        'first_level_commission' => 60.0,
        'second_level_commission' => 15.0,
        'is_affiliate_enabled' => true,
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

// Update commission rates
$response = $api->affiliates->updateAffiliateCommission(
    productId: 12345,
    commissionRate: 60.0,
    firstLevelCommission: 60.0,
    secondLevelCommission: 15.0
);

echo "Commission updated to {$response->commissionRate}%\n";

// Disable affiliate program
$response = $api->affiliates->updateAffiliateCommission(
    productId: 12345,
    isAffiliateEnabled: false
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid commission rate (must be 0-100) |
| 404 | Product not found | Product does not exist |
| 403 | Access denied | Not authorized to update this product |

## Notes

- Only provided fields will be updated
- Commission rates must be between 0 and 100
- Changes apply to future sales immediately
- Existing affiliate links remain valid
