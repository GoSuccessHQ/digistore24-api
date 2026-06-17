# listPayouts

List all payouts.

## Endpoint

```
POST /json/listPayouts
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `start_date` | string | No | Start date (Y-m-d) |
| `end_date` | string | No | End date (Y-m-d) |
| `status` | string | No | Filter by status (pending, paid, cancelled) |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'payouts' => [
            [
                'payout_id' => 12345,
                'period_start' => '2025-02-01',
                'period_end' => '2025-02-28',
                'amount' => 8540.50,
                'currency' => 'EUR',
                'status' => 'paid',
                'payment_method' => 'bank_transfer',
                'paid_at' => '2025-03-05T10:00:00Z',
                'transactions_count' => 127,
                'commission_total' => 456.20,
                'refunds_total' => 150.00,
                'net_amount' => 7934.30
            ],
            [
                'payout_id' => 12346,
                'period_start' => '2025-03-01',
                'period_end' => '2025-03-31',
                'amount' => 9240.00,
                'currency' => 'EUR',
                'status' => 'pending',
                'payment_method' => 'paypal',
                'expected_at' => '2025-04-05T10:00:00Z',
                'transactions_count' => 145,
                'commission_total' => 492.50,
                'refunds_total' => 80.00,
                'net_amount' => 8667.50
            ]
            // ... more payouts
        ],
        'total' => 24,
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

// List all payouts
$response = $api->payouts->listPayouts(
    limit: 50
);

echo "Total: {$response->total} payouts\n\n";
foreach ($response->payouts as $payout) {
    echo "Payout ID: {$payout->payoutId}\n";
    echo "Period: {$payout->periodStart} to {$payout->periodEnd}\n";
    echo "Amount: {$payout->currency} {$payout->amount}\n";
    echo "Net Amount: {$payout->currency} {$payout->netAmount}\n";
    echo "Status: {$payout->status}\n";
    echo "Transactions: {$payout->transactionsCount}\n";
    
    if ($payout->status == 'paid') {
        echo "Paid at: {$payout->paidAt}\n";
    } else {
        echo "Expected at: {$payout->expectedAt}\n";
    }
    echo "\n";
}

// Filter by date range
$response = $api->payouts->listPayouts(
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);

// Filter by status
$response = $api->payouts->listPayouts(
    status: 'paid'
);

// Get pending payouts
$response = $api->payouts->listPayouts(
    status: 'pending'
);

// Pagination for large result sets
$response = $api->payouts->listPayouts(
    limit: 20,
    offset: 0
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid date format or status |

## Notes

- Payouts typically processed monthly
- Status values: `pending`, `paid`, `cancelled`
- Payment methods: `bank_transfer`, `paypal`
- Net amount = amount - commissions - refunds
- Results ordered by period end date (newest first)
- Max 500 results per request
- Use pagination for complete history
