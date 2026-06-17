# getReferringAffiliate

Get the referring affiliate for a purchase or customer.

## Endpoint

```
POST /json/getReferringAffiliate
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | Yes* | Purchase ID |
| `email` | string | Yes* | Customer email |

*One of `purchase_id` or `email` is required.

## Response

```php
[
    'result' => 'success',
    'data' => [
        'affiliate_id' => 789,
        'affiliate_code' => 'AFFILIATE123',
        'affiliate_email' => 'affiliate@example.com',
        'affiliate_name' => 'John Doe',
        'referral_date' => '2025-10-15 10:30:00',
        'commission_earned' => 50.00
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

// Get referring affiliate for a purchase
$response = $api->affiliates->getReferringAffiliate(
    purchaseId: 'ABC123XYZ'
);

if ($response->affiliateId) {
    echo "Referred by: {$response->affiliateName}\n";
    echo "Commission: € {$response->commissionEarned}\n";
}

// Get referring affiliate for a customer
$response = $api->affiliates->getReferringAffiliate(
    email: 'customer@example.com'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Missing parameter | Neither purchase_id nor email provided |
| 404 | Not found | Purchase/customer not found or no affiliate referral |

## Notes

- Returns null if purchase was not through an affiliate
- For customers with multiple purchases, returns most recent affiliate
- Commission amount is for the specific purchase
