# statsDailyAmounts

Get daily amount statistics.

## Endpoint

```
POST /json/statsDailyAmounts
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `product_id` | int | No | Filter by product ID |
| `start_date` | string | Yes | Start date (Y-m-d) |
| `end_date` | string | Yes | End date (Y-m-d) |
| `currency` | string | No | Currency code (default: EUR) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'start_date' => '2025-03-01',
        'end_date' => '2025-03-31',
        'currency' => 'EUR',
        'daily_amounts' => [
            [
                'date' => '2025-03-01',
                'gross_amount' => 1245.00,
                'net_amount' => 1046.22,
                'vat_amount' => 198.78,
                'refunds' => 0.00,
                'transactions_count' => 12
            ],
            [
                'date' => '2025-03-02',
                'gross_amount' => 985.50,
                'net_amount' => 828.15,
                'vat_amount' => 157.35,
                'refunds' => 49.00,
                'transactions_count' => 10
            ]
            // ... more daily amounts
        ],
        'total_gross' => 38675.00,
        'total_net' => 32495.80,
        'total_vat' => 6179.20,
        'total_refunds' => 450.00,
        'total_transactions' => 345
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

// Get daily amounts for current month
$response = $api->statistics->statsDailyAmounts(
    startDate: '2025-03-01',
    endDate: '2025-03-31'
);

echo "Period: {$response->startDate} to {$response->endDate}\n";
echo "Total Gross: {$response->currency} {$response->totalGross}\n";
echo "Total Net: {$response->currency} {$response->totalNet}\n";
echo "Total VAT: {$response->currency} {$response->totalVat}\n";
echo "Total Refunds: {$response->currency} {$response->totalRefunds}\n";
echo "Total Transactions: {$response->totalTransactions}\n\n";

// Display daily breakdown
foreach ($response->dailyAmounts as $day) {
    echo "{$day->date}: {$response->currency} {$day->grossAmount} ";
    echo "({$day->transactionsCount} transactions)\n";
}

// Filter by product
$response = $api->statistics->statsDailyAmounts(
    productId: 123,
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);

// Get USD statistics
$response = $api->statistics->statsDailyAmounts(
    startDate: '2025-03-01',
    endDate: '2025-03-31',
    currency: 'USD'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid date format or range |
| 404 | Product not found | Specified product does not exist |

## Notes

- Maximum date range is 365 days
- Results include VAT breakdown
- Refunds are subtracted from daily amounts
- Use for financial reporting and analysis
- Data updated daily at midnight UTC
