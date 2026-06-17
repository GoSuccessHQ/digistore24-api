# createPaymentplan

Create a new payment plan.

## Endpoint

```
POST /json/createPaymentplan
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | Yes | Product ID |
| `name` | string | Yes | Payment plan name |
| `first_amount` | float | Yes | First payment amount |
| `first_amount_net` | float | No | First amount net (without VAT) |
| `rebill_amount` | float | Yes | Recurring payment amount |
| `rebill_amount_net` | float | No | Rebill amount net (without VAT) |
| `rebill_times` | int | Yes | Number of rebills (0 = unlimited) |
| `rebill_interval` | int | Yes | Interval in days |
| `currency` | string | No | Currency code (default: EUR) |
| `is_active` | bool | No | Active status (default: true) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'paymentplan_id' => 789,
        'product_id' => 123,
        'name' => 'Monthly Subscription',
        'first_amount' => 49.00,
        'first_amount_net' => 41.18,
        'rebill_amount' => 29.00,
        'rebill_amount_net' => 24.37,
        'rebill_times' => 0,
        'rebill_interval' => 30,
        'currency' => 'EUR',
        'is_active' => true,
        'created_at' => '2025-03-20T18:00:00Z'
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

// Create unlimited monthly subscription
$response = $api->paymentPlans->createPaymentplan(
    productId: 123,
    name: 'Monthly Subscription',
    firstAmount: 49.00,
    rebillAmount: 29.00,
    rebillTimes: 0,  // unlimited
    rebillInterval: 30  // 30 days
);

echo "Payment Plan ID: {$response->paymentplanId}\n";
echo "Name: {$response->name}\n";
echo "First Payment: € {$response->firstAmount}\n";
echo "Recurring: € {$response->rebillAmount} every {$response->rebillInterval} days\n";

// Create 12-month payment plan
$response = $api->paymentPlans->createPaymentplan(
    productId: 123,
    name: 'Annual Payment Plan (12 months)',
    firstAmount: 0.00,  // No initial payment
    rebillAmount: 49.00,
    rebillTimes: 12,  // 12 payments total
    rebillInterval: 30,
    currency: 'EUR'
);

// Create weekly payment plan
$response = $api->paymentPlans->createPaymentplan(
    productId: 123,
    name: 'Weekly Coaching',
    firstAmount: 99.00,
    rebillAmount: 49.00,
    rebillTimes: 8,  // 8 weeks
    rebillInterval: 7  // 7 days
);

// Create with net amounts (for VAT calculation)
$response = $api->paymentPlans->createPaymentplan(
    productId: 123,
    name: 'B2B Subscription',
    firstAmount: 119.00,
    firstAmountNet: 100.00,
    rebillAmount: 59.00,
    rebillAmountNet: 49.58,
    rebillTimes: 0,
    rebillInterval: 30
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid amounts or intervals |
| 404 | Product not found | Specified product does not exist |
| 403 | Access denied | No permission to create payment plans |

## Notes

- `rebill_times = 0` means unlimited recurring payments
- `rebill_interval` is in days (common: 7, 30, 90, 365)
- `first_amount` can be 0 for trial periods
- Supported currencies: EUR, USD, GBP, CHF
- Net amounts used for VAT calculation if provided
- Payment plan must be assigned to product to be used
