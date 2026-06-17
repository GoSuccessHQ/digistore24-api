# statsExpectedPayouts

Get expected payout statistics.

## Endpoint

```
POST /json/statsExpectedPayouts
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | No | Filter by product ID |
| `period` | string | No | Period (current_month, next_month, current_year) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'period' => 'current_month',
        'period_start' => '2025-03-01',
        'period_end' => '2025-03-31',
        'expected_amount' => 9240.00,
        'currency' => 'EUR',
        'transactions_count' => 145,
        'commission_total' => 492.50,
        'refunds_total' => 80.00,
        'expected_net' => 8667.50,
        'payout_date' => '2025-04-05',
        'by_product' => [
            [
                'product_id' => 123,
                'product_name' => 'Premium Course',
                'amount' => 5640.00,
                'transactions' => 87,
                'net' => 5280.50
            ],
            [
                'product_id' => 124,
                'product_name' => 'Basic Course',
                'amount' => 3600.00,
                'transactions' => 58,
                'net' => 3387.00
            ]
        ]
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

// Get current month expected payout
$response = $api->payouts->statsExpectedPayouts();

echo "Expected Payout for {$response->period}\n";
echo "Period: {$response->periodStart} to {$response->periodEnd}\n";
echo "Expected Amount: {$response->currency} {$response->expectedAmount}\n";
echo "Expected Net: {$response->currency} {$response->expectedNet}\n";
echo "Transactions: {$response->transactionsCount}\n";
echo "Commissions: {$response->currency} {$response->commissionTotal}\n";
echo "Refunds: {$response->currency} {$response->refundsTotal}\n";
echo "Expected Payout Date: {$response->payoutDate}\n\n";

// Show breakdown by product
if (!empty($response->byProduct)) {
    echo "Breakdown by Product:\n";
    foreach ($response->byProduct as $product) {
        echo "  {$product->productName}\n";
        echo "    Amount: {$response->currency} {$product->amount}\n";
        echo "    Transactions: {$product->transactions}\n";
        echo "    Net: {$response->currency} {$product->net}\n\n";
    }
}

// Get next month expected payout
$response = $api->payouts->statsExpectedPayouts(
    period: 'next_month'
);

echo "Next month expected: {$response->currency} {$response->expectedNet}\n";

// Get current year expected payout
$response = $api->payouts->statsExpectedPayouts(
    period: 'current_year'
);

echo "Year to date expected: {$response->currency} {$response->expectedNet}\n";

// Get expected payout for specific product
$response = $api->payouts->statsExpectedPayouts(
    productId: 123
);

echo "Product 123 expected: {$response->currency} {$response->expectedNet}\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid period or product ID |
| 404 | Product not found | Specified product does not exist |

## Notes

- Default period is `current_month`
- Available periods: `current_month`, `next_month`, `current_year`
- Expected payout calculated from pending transactions
- Includes estimated commissions and potential refunds
- Updated in real-time with each transaction
- Actual payout may differ due to refunds/chargebacks
- Use for financial planning and forecasting
