# getSmartupgrade

Get smart upgrade details.

## Endpoint

```
POST /json/getSmartupgrade
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `smartupgrade_id` | int | Yes | Smart upgrade ID |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'smartupgrade_id' => 567,
        'name' => 'Premium Upgrade Path',
        'from_product_id' => 123,
        'from_product_name' => 'Basic Course',
        'to_product_id' => 124,
        'to_product_name' => 'Premium Course',
        'upgrade_price' => 49.00,
        'currency' => 'EUR',
        'is_active' => true,
        'conversions_count' => 87,
        'conversion_rate' => 12.5,
        'created_at' => '2025-01-15T10:00:00Z'
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

// Get smart upgrade details
$response = $api->smartUpgrades->getSmartupgrade(
    smartupgradeId: 567
);

echo "Upgrade: {$response->name}\n";
echo "From: {$response->fromProductName}\n";
echo "To: {$response->toProductName}\n";
echo "Price: {$response->currency} {$response->upgradePrice}\n";
echo "Conversions: {$response->conversionsCount}\n";
echo "Conversion Rate: {$response->conversionRate}%\n";
echo "Status: " . ($response->isActive ? 'Active' : 'Inactive') . "\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid smart upgrade ID |
| 404 | Smart upgrade not found | Specified smart upgrade does not exist |
| 403 | Access denied | No permission to view this smart upgrade |

## Notes

- Smart upgrades allow customers to upgrade from one product to another
- Upgrade price is the difference between products
- Conversion rate = (conversions / offers shown) * 100
- Use for analyzing upgrade performance
