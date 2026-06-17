# getGlobalSettings

Get global Digistore24 settings and configuration.

## Endpoint

```
POST /json/getGlobalSettings
```

## Request Parameters

No parameters required.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'product_types' => [
            ['id' => 1, 'name' => 'Digital Product'],
            ['id' => 2, 'name' => 'Physical Product'],
            ['id' => 3, 'name' => 'Service'],
            ['id' => 4, 'name' => 'Subscription']
        ],
        'countries' => [
            ['code' => 'DE', 'name' => 'Germany'],
            ['code' => 'AT', 'name' => 'Austria'],
            // ... more countries
        ],
        'currencies' => [
            ['code' => 'EUR', 'symbol' => '€', 'name' => 'Euro'],
            ['code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar'],
            // ... more currencies
        ],
        'languages' => [
            ['code' => 'de', 'name' => 'Deutsch'],
            ['code' => 'en', 'name' => 'English'],
            ['code' => 'es', 'name' => 'Español']
        ],
        'payment_methods' => [
            'paypal', 'credit_card', 'sepa', 'sofort', 'giropay'
        ],
        'vat_rates' => [
            'DE' => 19.0,
            'AT' => 20.0,
            // ... more VAT rates
        ]
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

// Get all global settings
$response = $api->system->getGlobalSettings();

// List available product types
foreach ($response->productTypes as $type) {
    echo "Product Type: {$type->name} (ID: {$type->id})\n";
}

// Get supported countries
foreach ($response->countries as $country) {
    echo "{$country->code}: {$country->name}\n";
}

// Get currencies
foreach ($response->currencies as $currency) {
    echo "{$currency->code} ({$currency->symbol})\n";
}

// Check VAT rate for a country
$vatRate = $response->vatRates['DE'] ?? 0;
echo "VAT rate for Germany: {$vatRate}%";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 401 | Unauthorized | Invalid or missing API key |
| 403 | Forbidden | API key is disabled |

## Notes

- Response includes all reference data needed for API operations
- Use product type IDs when creating products
- Country codes are ISO 3166-1 alpha-2
- Currency codes are ISO 4217
- VAT rates may change; query regularly
- Settings are cached; may be up to 1 hour old
