# listTransactions

List all transactions.

## Endpoint

```
POST /json/listTransactions
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | No | Filter by purchase ID |
| `product_id` | int | No | Filter by product ID |
| `transaction_type` | string | No | Filter by type (sale, refund, chargeback, rebilling) |
| `status` | string | No | Filter by status (completed, pending, failed, cancelled) |
| `start_date` | string | No | Start date (Y-m-d) |
| `end_date` | string | No | End date (Y-m-d) |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'transactions' => [
            [
                'transaction_id' => 'TXN-12345',
                'purchase_id' => 'ABCD1234',
                'product_id' => 123,
                'product_name' => 'Premium Course',
                'buyer_email' => 'customer@example.com',
                'transaction_type' => 'sale',
                'amount' => 99.00,
                'currency' => 'EUR',
                'payment_method' => 'credit_card',
                'status' => 'completed',
                'created_at' => '2025-03-15T10:30:00Z'
            ],
            [
                'transaction_id' => 'TXN-12346',
                'purchase_id' => 'ABCD1234',
                'product_id' => 123,
                'product_name' => 'Premium Course',
                'buyer_email' => 'customer@example.com',
                'transaction_type' => 'rebilling',
                'amount' => 29.00,
                'currency' => 'EUR',
                'payment_method' => 'credit_card',
                'status' => 'completed',
                'created_at' => '2025-04-15T10:00:00Z'
            ]
            // ... more transactions
        ],
        'total' => 1245,
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

// List all transactions
$response = $api->transactions->listTransactions(
    limit: 50
);

echo "Total transactions: {$response->total}\n\n";
foreach ($response->transactions as $txn) {
    echo "ID: {$txn->transactionId}\n";
    echo "Type: {$txn->transactionType}\n";
    echo "Amount: {$txn->currency} {$txn->amount}\n";
    echo "Status: {$txn->status}\n";
    echo "Date: {$txn->createdAt}\n\n";
}

// Filter by purchase
$response = $api->transactions->listTransactions(
    purchaseId: 'ABCD1234'
);

// Filter by product
$response = $api->transactions->listTransactions(
    productId: 123
);

// Filter by type
$response = $api->transactions->listTransactions(
    transactionType: 'refund'
);

// Filter by status
$response = $api->transactions->listTransactions(
    status: 'failed'
);

// Filter by date range
$response = $api->transactions->listTransactions(
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);

// Combined filters
$response = $api->transactions->listTransactions(
    productId: 123,
    transactionType: 'sale',
    status: 'completed',
    startDate: '2025-03-01',
    endDate: '2025-03-31'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid filter values or pagination parameters |

## Notes

- Transaction types: `sale`, `refund`, `chargeback`, `rebilling`
- Status values: `completed`, `pending`, `failed`, `cancelled`
- Results ordered by creation date (newest first)
- Max 500 results per request
- Use pagination for large result sets
- Filter combinations supported
