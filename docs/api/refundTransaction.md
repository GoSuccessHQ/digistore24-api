# refundTransaction

Refund a transaction.

## Endpoint

```
POST /json/refundTransaction
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `transaction_id` | string | Yes | Transaction ID to refund |
| `amount` | float | No | Partial refund amount (empty = full refund) |
| `reason` | string | No | Reason for refund |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'refund_id' => 'REF-98765',
        'transaction_id' => 'TXN-12345',
        'purchase_id' => 'ABCD1234',
        'refunded_amount' => 99.00,
        'currency' => 'EUR',
        'reason' => 'Customer request',
        'status' => 'completed',
        'refunded_at' => '2025-03-20T15:30:00Z'
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

// Full refund
$response = $api->transactions->refundTransaction(
    transactionId: 'TXN-12345'
);

echo "Refund ID: {$response->refundId}\n";
echo "Amount: {$response->currency} {$response->refundedAmount}\n";
echo "Status: {$response->status}\n";

// Full refund with reason
$response = $api->transactions->refundTransaction(
    transactionId: 'TXN-12345',
    reason: 'Customer not satisfied'
);

// Partial refund
$response = $api->transactions->refundTransaction(
    transactionId: 'TXN-12345',
    amount: 49.50,
    reason: 'Partial service provided'
);

echo "Partial refund of {$response->currency} {$response->refundedAmount}\n";

// Example: Refund with error handling
try {
    $response = $api->transactions->refundTransaction(
        transactionId: 'TXN-12345',
        reason: 'Duplicate payment'
    );
    
    if ($response->status === 'completed') {
        echo "Refund processed successfully\n";
        echo "Refund ID: {$response->refundId}\n";
    }
} catch (\Exception $e) {
    echo "Refund failed: {$e->getMessage()}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid transaction ID or amount |
| 404 | Transaction not found | Specified transaction does not exist |
| 403 | Access denied | No permission to refund this transaction |
| 409 | Already refunded | Transaction has already been refunded |
| 409 | Refund exceeds amount | Partial refund amount exceeds transaction amount |

## Notes

- Full refund if amount not specified
- Partial refunds supported
- Cannot refund more than original amount
- Cannot refund already refunded transactions
- Refund processed immediately or within 1-3 business days
- Customer receives email notification
- Access to product may be revoked
