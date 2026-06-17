# listSmartUpgrades

List all smart upgrades.

## Endpoint

```
POST /json/listSmartUpgrades
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `from_product_id` | int | No | Filter by source product ID |
| `to_product_id` | int | No | Filter by target product ID |
| `is_active` | bool | No | Filter by active status |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'smartupgrades' => [
            [
                'smartupgrade_id' => 567,
                'name' => 'Basic to Premium',
                'from_product_id' => 123,
                'from_product_name' => 'Basic Course',
                'to_product_id' => 124,
                'to_product_name' => 'Premium Course',
                'upgrade_price' => 49.00,
                'currency' => 'EUR',
                'is_active' => true,
                'conversions_count' => 87,
                'conversion_rate' => 12.5
            ],
            [
                'smartupgrade_id' => 568,
                'name' => 'Premium to VIP',
                'from_product_id' => 124,
                'from_product_name' => 'Premium Course',
                'to_product_id' => 125,
                'to_product_name' => 'VIP Course',
                'upgrade_price' => 99.00,
                'currency' => 'EUR',
                'is_active' => true,
                'conversions_count' => 45,
                'conversion_rate' => 8.3
            ]
            // ... more smart upgrades
        ],
        'total' => 12,
        'limit' => 100,
        'offset' => 0
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

// List all smart upgrades
$response = $api->smartUpgrades->listSmartUpgrades(
    limit: 50
);

echo "Total smart upgrades: {$response->total}\n\n";
foreach ($response->smartupgrades as $upgrade) {
    echo "ID: {$upgrade->smartupgradeId}\n";
    echo "Name: {$upgrade->name}\n";
    echo "Path: {$upgrade->fromProductName} → {$upgrade->toProductName}\n";
    echo "Price: {$upgrade->currency} {$upgrade->upgradePrice}\n";
    echo "Conversions: {$upgrade->conversionsCount} ({$upgrade->conversionRate}%)\n\n";
}

// Filter by source product
$response = $api->smartUpgrades->listSmartUpgrades(
    fromProductId: 123
);

// Filter by target product
$response = $api->smartUpgrades->listSmartUpgrades(
    toProductId: 124
);

// Filter active upgrades only
$response = $api->smartUpgrades->listSmartUpgrades(
    isActive: true
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid filter values or pagination parameters |

## Notes

- Results ordered by creation date (newest first)
- Includes conversion statistics
- Max 500 results per request
- Use pagination for large result sets
- Filter combinations supported
