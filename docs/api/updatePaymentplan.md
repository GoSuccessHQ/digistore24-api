# updatePaymentplan

Update an existing payment plan.

## Endpoint

```
POST /json/updatePaymentplan
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `paymentplan_id` | int | Yes | Payment plan ID |
| `name` | string | No | Payment plan name |
| `first_amount` | float | No | First payment amount |
| `first_amount_net` | float | No | First amount net (without VAT) |
| `rebill_amount` | float | No | Recurring payment amount |
| `rebill_amount_net` | float | No | Rebill amount net (without VAT) |
| `rebill_times` | int | No | Number of rebills (0 = unlimited) |
| `rebill_interval` | int | No | Interval in days |
| `is_active` | bool | No | Active status |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'paymentplan_id' => 789,
        'product_id' => 123,
        'name' => 'Updated Monthly Plan',
        'first_amount' => 59.00,
        'first_amount_net' => 49.58,
        'rebill_amount' => 39.00,
        'rebill_amount_net' => 32.77,
        'rebill_times' => 0,
        'rebill_interval' => 30,
        'currency' => 'EUR',
        'is_active' => true,
        'updated_at' => '2025-03-20T19:15:00Z'
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

// Update payment plan name
$response = $api->paymentPlans->updatePaymentplan(
    paymentplanId: 789,
    name: 'Updated Monthly Plan'
);

echo "Payment plan updated: {$response->name}\n";

// Update pricing
$response = $api->paymentPlans->updatePaymentplan(
    paymentplanId: 789,
    firstAmount: 59.00,
    rebillAmount: 39.00
);

echo "First payment: € {$response->firstAmount}\n";
echo "Recurring: € {$response->rebillAmount}\n";

// Change rebill settings
$response = $api->paymentPlans->updatePaymentplan(
    paymentplanId: 789,
    rebillTimes: 12,  // Change from unlimited to 12 payments
    rebillInterval: 30
);

// Deactivate payment plan
$response = $api->paymentPlans->updatePaymentplan(
    paymentplanId: 789,
    isActive: false
);

if (!$response->isActive) {
    echo "Payment plan deactivated\n";
}

// Update with net amounts for VAT
$response = $api->paymentPlans->updatePaymentplan(
    paymentplanId: 789,
    firstAmount: 119.00,
    firstAmountNet: 100.00,
    rebillAmount: 59.00,
    rebillAmountNet: 49.58
);

// Update multiple settings
$response = $api->paymentPlans->updatePaymentplan(
    paymentplanId: 789,
    name: 'Premium Monthly',
    firstAmount: 99.00,
    rebillAmount: 49.00,
    rebillTimes: 0,
    rebillInterval: 30,
    isActive: true
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid amounts or intervals |
| 404 | Payment plan not found | Specified payment plan does not exist |
| 403 | Access denied | No permission to update this payment plan |
| 409 | Cannot modify | Cannot change plan with active subscriptions |

## Notes

- Only provided parameters are updated
- Other settings remain unchanged
- Changes do NOT affect existing subscriptions
- New subscriptions will use updated settings
- Cannot change `product_id` or `currency`
- Deactivating prevents new subscriptions but keeps existing ones active
- Consider creating new plan instead of modifying active one
