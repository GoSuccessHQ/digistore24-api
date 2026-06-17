# setReferringAffiliate

Set or update the referring affiliate for a customer.

## Endpoint

```
POST /json/setReferringAffiliate
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `email` | string | Yes | Customer email address |
| `affiliate_code` | string | Yes* | Affiliate code |
| `affiliate_id` | int | Yes* | Affiliate ID |

*One of `affiliate_code` or `affiliate_id` is required.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'email' => 'customer@example.com',
        'affiliate_id' => 789,
        'affiliate_code' => 'AFFILIATE123',
        'set_at' => '2025-10-15 14:30:00'
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

// Set affiliate by code
$response = $api->affiliates->setReferringAffiliate(
    email: 'customer@example.com',
    affiliateCode: 'AFFILIATE123'
);

echo "Affiliate set for {$response->email}\n";

// Set affiliate by ID
$response = $api->affiliates->setReferringAffiliate(
    email: 'customer@example.com',
    affiliateId: 789
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Missing required parameters |
| 404 | Affiliate not found | Affiliate does not exist |
| 422 | Invalid email | Email format is invalid |

## Notes

- Assigns affiliate to customer for future purchases
- Overrides any existing affiliate assignment
- Does not affect past purchases
- Useful for manual affiliate assignment or corrections
