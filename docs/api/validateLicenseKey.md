# validateLicenseKey

Validate a software license key.

## Endpoint

```
POST /json/validateLicenseKey
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `license_key` | string | Yes | License key to validate |
| `product_id` | int | No | Product ID for validation scope |
| `email` | string | No | Customer email for additional validation |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'valid' => true,
        'license_key' => 'XXXX-XXXX-XXXX-XXXX',
        'product_id' => 12345,
        'product_name' => 'My Software',
        'customer_email' => 'customer@example.com',
        'purchase_date' => '2025-10-15 10:30:00',
        'expires_at' => '2026-10-15 10:30:00',
        'is_active' => true,
        'activations_used' => 2,
        'activations_max' => 5
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

// Validate a license key
$response = $api->licenses->validateLicenseKey(
    licenseKey: 'XXXX-XXXX-XXXX-XXXX',
    productId: 12345
);

if ($response->valid) {
    echo "License is valid for: " . $response->productName;
    echo "Activations: {$response->activationsUsed}/{$response->activationsMax}";
} else {
    echo "Invalid or expired license";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid license key format | License key format is incorrect |
| 404 | License not found | License key does not exist |
| 410 | License expired | License key has expired |
| 429 | Too many activation attempts | Rate limit exceeded |

## Notes

- Use this endpoint to implement license validation in your software
- Supports activation limits and expiration dates
- Returns detailed license information for valid keys
- Can be used for both one-time and subscription licenses
