# ipnSetup

Setup IPN (Instant Payment Notification) webhook for receiving payment notifications.

## Endpoint

```
POST /ipnSetup
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `ipn_url` | string | Yes | URL where Digistore24 sends the IPN notification |
| `name` | string | Yes | The name listed on Digistore (e.g. your platform name) |
| `product_ids` | string | Yes | "all" or a comma-separated list of product IDs |
| `domain_id` | string | No | Used to delete the IPN connection and ensure uniqueness. Usually your platform name |
| `categories` | array | No | Transaction categories (orders, affiliations, etickets, customforms, orderform) |
| `transactions` | array | No | Transaction types (payment, refund, chargeback, payment_missed, payment_denial, rebill_cancelled, rebill_resumed, last_paid_day) |
| `timing` | string | No | When to send IPN: "before_thankyou" (default) or "delayed" |
| `sha_passphrase` | string | No | Password for signing parameters. Use "random" for auto-generated 30-char password |
| `newsletter_send_policy` | string | No | When to send IPN based on newsletter opt-in status |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'domain_id' => 'my-platform',
        'ipn_url' => 'https://yoursite.com/webhook',
        'name' => 'My Platform',
        'created_at' => '2025-10-15 14:30:00'
    ]
]
```

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Enum\IpnNewsletterSendPolicy;
use GoSuccess\Digistore24\Api\Enum\IpnTiming;
use GoSuccess\Digistore24\Api\Enum\IpnTransactionCategory;
use GoSuccess\Digistore24\Api\Enum\IpnTransactionType;
use GoSuccess\Digistore24\Api\Request\Ipn\IpnSetupRequest;

// Initialize API client
$config = new Configuration('YOUR-API-KEY');
$api = new Digistore24($config);

// Setup IPN for all products with default settings
$request = new IpnSetupRequest(
    ipnUrl: 'https://yoursite.com/webhook',
    name: 'My Platform',
    productIds: 'all'
);
$response = $api->ipn->setup($request);

// Setup IPN with custom configuration
$request = new IpnSetupRequest(
    ipnUrl: 'https://yoursite.com/webhook',
    name: 'My Platform',
    productIds: '123,456',
    domainId: 'my-platform',
    categories: [
        IpnTransactionCategory::ORDERS,
        IpnTransactionCategory::AFFILIATIONS
    ],
    transactions: [
        IpnTransactionType::PAYMENT,
        IpnTransactionType::REFUND,
        IpnTransactionType::CHARGEBACK
    ],
    timing: IpnTiming::DELAYED,
    shaPassphrase: 'random',
    newsletterSendPolicy: IpnNewsletterSendPolicy::SEND_IF_OPTIN
);
$response = $api->ipn->setup($request);

echo "IPN configured for: {$response->name}";
```

## Transaction Types

- `all` - All transaction types
- `payment` - New payment received
- `refund` - Payment refunded
- `chargeback` - Chargeback initiated
- `payment_missed` - Scheduled payment missed
- `payment_denial` - Payment denied
- `rebill_cancelled` - Subscription cancelled
- `rebill_resumed` - Subscription resumed
- `last_paid_day` - Last payment day notification

## Transaction Categories

- `orders` - Order transactions
- `affiliations` - Affiliate transactions
- `etickets` - E-Ticket transactions
- `customforms` - Custom form submissions
- `orderform` - Order form transactions

## Newsletter Send Policy

- `send_always` - Always send IPN (default)
- `send_if_not_optout` - Send if not opted out
- `send_if_optout` - Send only if opted out
- `send_if_optin` - Send only if opted in

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid URL | Webhook URL is invalid or unreachable |
| 422 | Invalid parameters | Required parameters missing or invalid |
| 409 | IPN already exists | IPN already configured for this domain_id |

## Notes

- Webhook URL must be publicly accessible via HTTPS
- Use `domain_id` to uniquely identify your IPN connection
- Default transactions: payment, refund, chargeback, payment_missed
- Default timing: before_thankyou
- Digistore24 will retry failed webhooks automatically
- Use sha_passphrase="random" for auto-generated secure password
