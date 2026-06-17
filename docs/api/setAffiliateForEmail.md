# setAffiliateForEmail

Create or update affiliate for an email address.

## Endpoint

```
POST /json/setAffiliateForEmail
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `email` | string | Yes | Email address |
| `first_name` | string | No | First name |
| `last_name` | string | No | Last name |
| `affiliate_code` | string | No | Custom affiliate code (auto-generated if not provided) |
| `is_active` | bool | No | Active status (default: true) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'affiliate_id' => 789,
        'email' => 'newaffiliate@example.com',
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'affiliate_code' => 'JANE2025',
        'is_active' => true,
        'created_at' => '2025-10-15 14:30:00'
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

// Create new affiliate
$response = $api->affiliates->setAffiliateForEmail(
    email: 'newaffiliate@example.com',
    firstName: 'Jane',
    lastName: 'Smith',
    affiliateCode: 'JANE2025'
);

echo "Affiliate created: {$response->affiliateId}\n";
echo "Affiliate code: {$response->affiliateCode}\n";

// Update existing affiliate
$response = $api->affiliates->setAffiliateForEmail(
    email: 'existing@example.com',
    isActive: false
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Missing email or invalid format |
| 409 | Affiliate code exists | Custom code already in use |
| 422 | Validation error | Invalid affiliate code format |

## Notes

- Creates affiliate if email doesn't exist, updates if it does
- Affiliate codes must be unique
- Auto-generated codes are based on name/email
- Inactive affiliates cannot earn new commissions
