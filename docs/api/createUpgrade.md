# createUpgrade

Create a new upgrade path.

## Endpoint

```
POST /json/createUpgrade
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `name` | string | Yes | Upgrade name |
| `from_product_id` | int | Yes | Source product ID |
| `to_product_id` | int | Yes | Target product ID |
| `upgrade_price` | float | Yes | Upgrade price |
| `currency` | string | No | Currency code (default: EUR) |
| `description` | string | No | Upgrade description |
| `is_active` | bool | No | Active status (default: true) |

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
        'created_at' => '2025-03-21T00:30:00Z'
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

// Create upgrade
$response = $api->upgrades->createUpgrade(
    name: 'Basic to Premium Upgrade',
    fromProductId: 123,
    toProductId: 124,
    upgradePrice: 49.00
);

echo "Upgrade ID: {$response->upgradeId}\n";
echo "Name: {$response->name}\n";
echo "From: {$response->fromProductName}\n";
echo "To: {$response->toProductName}\n";
echo "Price: {$response->currency} {$response->upgradePrice}\n";

// Create with description
$response = $api->upgrades->createUpgrade(
    name: 'Premium to VIP Upgrade',
    fromProductId: 124,
    toProductId: 125,
    upgradePrice: 99.00,
    description: 'Get exclusive VIP access and bonuses'
);

// Create with custom currency
$response = $api->upgrades->createUpgrade(
    name: 'Standard to Pro',
    fromProductId: 101,
    toProductId: 102,
    upgradePrice: 79.00,
    currency: 'USD',
    description: 'Unlock professional features'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid price or product IDs |
| 404 | Product not found | One or both products do not exist |
| 403 | Access denied | No permission to create upgrades |
| 409 | Upgrade exists | Upgrade path already exists |

## Notes

- Cannot upgrade from and to same product
- Upgrade price typically less than target product price
- Customers pay upgrade price to switch products
- Access to original product maintained until upgrade
- Use for product upselling strategies
