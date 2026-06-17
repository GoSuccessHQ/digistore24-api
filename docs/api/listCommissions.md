# listCommissions

List affiliate commissions.

## Endpoint

```
POST /json/listCommissions
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `affiliate_id` | string | No | Filter by affiliate ID |
| `product_id` | int | No | Filter by product ID |
| `purchase_id` | string | No | Filter by purchase ID |
| `status` | string | No | Filter by status (pending, approved, paid, cancelled) |
| `start_date` | string | No | Start date (Y-m-d) |
| `end_date` | string | No | End date (Y-m-d) |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'commissions' => [
            [
                'commission_id' => 98765,
                'affiliate_id' => 'AFF12345',
                'affiliate_name' => 'John Affiliate',
                'purchase_id' => 'ABCD1234',
                'product_id' => 123,
                'product_name' => 'Premium Course',
                'amount' => 19.80,
                'currency' => 'EUR',
                'commission_rate' => 20.00,
                'status' => 'approved',
                'created_at' => '2025-03-15T10:30:00Z',
                'approved_at' => '2025-03-16T08:00:00Z'
            ],
            [
                'commission_id' => 98766,
                'affiliate_id' => 'AFF12345',
                'affiliate_name' => 'John Affiliate',
                'purchase_id' => 'EFGH5678',
                'product_id' => 124,
                'product_name' => 'Basic Course',
                'amount' => 9.90,
                'currency' => 'EUR',
                'commission_rate' => 15.00,
                'status' => 'paid',
                'created_at' => '2025-03-10T14:00:00Z',
                'approved_at' => '2025-03-11T08:00:00Z',
                'paid_at' => '2025-03-20T10:00:00Z'
            ]
            // ... more commissions
        ],
        'total' => 245,
        'total_amount' => 4856.40,
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

// List all commissions
$response = $api->commissions->listCommissions(
    limit: 50
);

echo "Total commissions: {$response->total}\n";
echo "Total amount: {$response->commissions[0]->currency} {$response->totalAmount}\n\n";

foreach ($response->commissions as $commission) {
    echo "ID: {$commission->commissionId}\n";
    echo "Affiliate: {$commission->affiliateName} ({$commission->affiliateId})\n";
    echo "Product: {$commission->productName}\n";
    echo "Amount: {$commission->currency} {$commission->amount} ({$commission->commissionRate}%)\n";
    echo "Status: {$commission->status}\n\n";
}

// Filter by affiliate
$response = $api->commissions->listCommissions(
    affiliateId: 'AFF12345'
);

// Filter by product
$response = $api->commissions->listCommissions(
    productId: 123
);

// Filter by status
$response = $api->commissions->listCommissions(
    status: 'approved'
);

// Filter by date range
$response = $api->commissions->listCommissions(
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);

// Combined filters
$response = $api->commissions->listCommissions(
    affiliateId: 'AFF12345',
    status: 'paid',
    startDate: '2025-03-01',
    endDate: '2025-03-31'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid filter values or pagination parameters |

## Notes

- Status values: `pending`, `approved`, `paid`, `cancelled`
- Pending: Waiting for approval period
- Approved: Ready for payout
- Paid: Commission has been paid out
- Cancelled: Purchase refunded or cancelled
- Results ordered by creation date (newest first)
- Max 500 results per request
- Use pagination for large result sets
