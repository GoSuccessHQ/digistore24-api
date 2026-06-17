# listCurrencies

List all supported currencies.

## Endpoint

```
POST /json/listCurrencies
```

## Request Parameters

No parameters required.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'currencies' => [
            [
                'code' => 'EUR',
                'symbol' => '€',
                'name' => 'Euro',
                'decimal_places' => 2
            ],
            [
                'code' => 'USD',
                'symbol' => '$',
                'name' => 'US Dollar',
                'decimal_places' => 2
            ],
            [
                'code' => 'GBP',
                'symbol' => '£',
                'name' => 'British Pound',
                'decimal_places' => 2
            ],
            // ... more currencies
        ],
        'total' => 150
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

// Get all currencies
$response = $api->countries->listCurrencies();

foreach ($response->currencies as $currency) {
    echo "{$currency->code} ({$currency->symbol}): {$currency->name}\n";
}

// Build currency selector
$currencies = array_column($response->currencies, 'code');
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 500 | Server error | Internal error retrieving currencies |

## Notes

- Currency codes are ISO 4217
- Includes currency symbols for display
- Decimal places indicate precision (usually 2)
- Use for multi-currency pricing
- Exchange rates not included (use separate service)
