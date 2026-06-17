# listPaymentPlans

List all payment plans.

## Endpoint

```
POST /json/listPaymentPlans
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | No | Filter by product ID |
| `is_active` | bool | No | Filter by active status |
| `currency` | string | No | Filter by currency |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'paymentplans' => [
            [
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
                'active_subscriptions' => 145,
                'total_revenue' => 12685.00,
                'created_at' => '2025-01-10T10:00:00Z'
            ],
            [
                'paymentplan_id' => 790,
                'product_id' => 123,
                'name' => 'Annual Plan',
                'first_amount' => 0.00,
                'first_amount_net' => 0.00,
                'rebill_amount' => 49.00,
                'rebill_amount_net' => 41.18,
                'rebill_times' => 12,
                'rebill_interval' => 30,
                'currency' => 'EUR',
                'is_active' => true,
                'active_subscriptions' => 67,
                'total_revenue' => 39396.00,
                'created_at' => '2025-02-15T14:30:00Z'
            ]
            // ... more payment plans
        ],
        'total' => 23,
        'limit' => 100,
        'offset' => 0
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

// List all payment plans
$response = $api->paymentPlans->listPaymentPlans(
    limit: 50
);

echo "Total: {$response->total} payment plans\n\n";
foreach ($response->paymentplans as $plan) {
    echo "ID: {$plan->paymentplanId}\n";
    echo "Name: {$plan->name}\n";
    echo "First: € {$plan->firstAmount}\n";
    echo "Rebill: € {$plan->rebillAmount} every {$plan->rebillInterval} days\n";
    
    if ($plan->rebillTimes == 0) {
        echo "Duration: Unlimited\n";
    } else {
        echo "Duration: {$plan->rebillTimes} payments\n";
    }
    
    echo "Active Subscriptions: {$plan->activeSubscriptions}\n";
    echo "Total Revenue: € {$plan->totalRevenue}\n\n";
}

// Filter by product
$response = $api->paymentPlans->listPaymentPlans(
    productId: 123
);

// Filter active plans only
$response = $api->paymentPlans->listPaymentPlans(
    isActive: true
);

// Filter by currency
$response = $api->paymentPlans->listPaymentPlans(
    currency: 'USD'
);

// Pagination
$response = $api->paymentPlans->listPaymentPlans(
    limit: 20,
    offset: 0
);

// Combined filters
$response = $api->paymentPlans->listPaymentPlans(
    productId: 123,
    isActive: true,
    currency: 'EUR'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid filter values or pagination parameters |

## Notes

- Results ordered by creation date (newest first)
- Includes active subscription count and revenue statistics
- Max 500 results per request
- Use pagination for large result sets
- Revenue statistics updated daily
- Filter combinations supported
