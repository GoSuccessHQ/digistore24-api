# ipnInfo

Retrieve configured IPN (Instant Payment Notification) webhook information.

## Endpoint

```
GET /ipnInfo
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `domain_id` | string | No | Filter by specific domain ID. If omitted, returns all IPNs |

## Response

```php
[
    'result' => 'success',
    'data' => [
        [
            'domain_id' => 'my-platform',
            'ipn_url' => 'https://yoursite.com/webhook',
            'name' => 'My Platform',
            'product_ids' => 'all',
            'categories' => ['orders', 'affiliations'],
            'transactions' => ['payment', 'refund', 'chargeback'],
            'timing' => 'before_thankyou',
            'sha_passphrase' => '***',
            'newsletter_send_policy' => 'send_always',
            'created_at' => '2025-10-15 14:30:00',
            'updated_at' => '2025-11-20 10:15:00'
        ]
    ]
]
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Ipn\IpnInfoRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Get all configured IPNs
$request = new IpnInfoRequest();
$response = $api->ipn->info($request);

foreach ($response->data as $ipn) {
    echo "IPN: {$ipn['name']} - {$ipn['ipn_url']}\n";
}

// Get specific IPN by domain ID
$request = new IpnInfoRequest(domainId: 'my-platform');
$response = $api->ipn->info($request);

if (!empty($response->data)) {
    $ipn = $response->data[0];
    echo "Domain: {$ipn['domain_id']}\n";
    echo "URL: {$ipn['ipn_url']}\n";
    echo "Products: {$ipn['product_ids']}\n";
    echo "Timing: {$ipn['timing']}\n";
}
```

## Response Fields

| Field | Type | Description |
|-------|------|-------------|
| `domain_id` | string | Unique identifier for this IPN connection |
| `ipn_url` | string | Webhook URL receiving notifications |
| `name` | string | Platform name listed on Digistore |
| `product_ids` | string | "all" or comma-separated product IDs |
| `categories` | array | Transaction categories (orders, affiliations, etc.) |
| `transactions` | array | Transaction types (payment, refund, etc.) |
| `timing` | string | Notification timing (before_thankyou, delayed) |
| `sha_passphrase` | string | Masked passphrase for security |
| `newsletter_send_policy` | string | Newsletter-based send policy |
| `created_at` | string | IPN creation timestamp |
| `updated_at` | string | Last update timestamp |

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | IPN not found | No IPN configured with specified domain_id |
| 401 | Unauthorized | Invalid API key |

## Notes

- Without `domain_id` parameter, returns all configured IPNs
- SHA passphrase is always masked (***) for security
- Use this to verify IPN configuration before testing
- Check `timing` field to understand when webhooks are sent
- Returns empty array if no IPNs configured
