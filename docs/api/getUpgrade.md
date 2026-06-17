# getUpgrade

Get upgrade details.

## Endpoint

```
POST /json/getUpgrade
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `upgrade_id` | int | Yes | Upgrade ID |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'upgrade_id' => 789,
        'name' => 'Basic to Premium Upgrade',
        'from_product_id' => 123,
        'from_product_name' => 'Basic Course',
        'to_product_id' => 124,
        'to_product_name' => 'Premium Course',
        'upgrade_price' => 49.00,
        'currency' => 'EUR',
        'description' => 'Upgrade to premium features',
        'is_active' => true,
        'conversions_count' => 87,
        'conversion_rate' => 12.5,
        'total_revenue' => 4263.00,
        'created_at' => '2025-01-15T10:00:00Z',
        'updated_at' => '2025-03-20T14:30:00Z'
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

// Get upgrade details
$response = $api->upgrades->getUpgrade(
    upgradeId: 789
);

echo "Upgrade: {$response->name}\n";
echo "From: {$response->fromProductName}\n";
echo "To: {$response->toProductName}\n";
echo "Price: {$response->currency} {$response->upgradePrice}\n";
echo "Description: {$response->description}\n\n";

echo "Performance:\n";
echo "Conversions: {$response->conversionsCount}\n";
echo "Conversion Rate: {$response->conversionRate}%\n";
echo "Total Revenue: {$response->currency} {$response->totalRevenue}\n";
echo "Status: " . ($response->isActive ? 'Active' : 'Inactive') . "\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid upgrade ID |
| 404 | Upgrade not found | Specified upgrade does not exist |
| 403 | Access denied | No permission to view this upgrade |

## Notes

- Includes conversion statistics
- Conversion rate = (conversions / offers shown) * 100
- Total revenue = conversions * upgrade price
- Use for upgrade performance analysis
