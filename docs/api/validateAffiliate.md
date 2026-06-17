# validateAffiliate

Validate affiliate credentials and status.

## Endpoint

```
POST /json/validateAffiliate
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `affiliate_code` | string | Yes* | Affiliate code |
| `affiliate_id` | int | Yes* | Affiliate ID |

*One of `affiliate_code` or `affiliate_id` is required.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'valid' => true,
        'affiliate_id' => 789,
        'affiliate_code' => 'AFFILIATE123',
        'is_active' => true,
        'email' => 'affiliate@example.com',
        'name' => 'John Doe'
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

// Validate by affiliate code
$response = $api->affiliates->validateAffiliate(
    affiliateCode: 'AFFILIATE123'
);

if ($response->valid && $response->isActive) {
    echo "Valid affiliate: {$response->name}\n";
} else {
    echo "Invalid or inactive affiliate\n";
}

// Validate by affiliate ID
$response = $api->affiliates->validateAffiliate(
    affiliateId: 789
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Missing parameter | Neither code nor ID provided |
| 404 | Affiliate not found | Affiliate does not exist |

## Notes

- Use this before processing affiliate referrals
- Inactive affiliates return valid=true but isActive=false
- Returns affiliate details for valid credentials
