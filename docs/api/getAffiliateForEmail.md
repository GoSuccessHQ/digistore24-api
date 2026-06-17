# getAffiliateForEmail

Get affiliate information by email address.

## Endpoint

```
POST /json/getAffiliateForEmail
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `email` | string | Yes | Affiliate's email address |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'affiliate_id' => 789,
        'email' => 'affiliate@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'affiliate_code' => 'AFFILIATE123',
        'is_active' => true,
        'commission_balance' => 1250.50,
        'total_sales' => 5000.00,
        'created_at' => '2024-01-15 10:30:00'
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

// Get affiliate by email
$response = $api->affiliates->getAffiliateForEmail(
    email: 'affiliate@example.com'
);

if ($response->isActive) {
    echo "Affiliate: {$response->firstName} {$response->lastName}\n";
    echo "Code: {$response->affiliateCode}\n";
    echo "Balance: € {$response->commissionBalance}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | Affiliate not found | No affiliate with this email exists |
| 400 | Invalid email | Email format is invalid |

## Notes

- Returns comprehensive affiliate information including stats
- Use this to validate affiliate existence before operations
- Commission balance shows unpaid earnings
