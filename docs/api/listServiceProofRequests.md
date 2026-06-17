# listServiceProofRequests

List all service proof requests.

## Endpoint

```
POST /json/listServiceProofRequests
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `status` | string | No | Filter by status (pending, submitted, approved, rejected) |
| `product_id` | int | No | Filter by product ID |
| `start_date` | string | No | Start date (Y-m-d) |
| `end_date` | string | No | End date (Y-m-d) |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'requests' => [
            [
                'request_id' => 456,
                'purchase_id' => 'ABCD1234',
                'buyer_email' => 'customer@example.com',
                'product_name' => 'Premium Course',
                'requested_at' => '2025-03-15T10:00:00Z',
                'status' => 'pending',
                'deadline' => '2025-03-29T23:59:59Z',
                'documents_count' => 0
            ],
            [
                'request_id' => 457,
                'purchase_id' => 'EFGH5678',
                'buyer_email' => 'buyer@example.com',
                'product_name' => 'Online Workshop',
                'requested_at' => '2025-03-10T14:00:00Z',
                'status' => 'submitted',
                'deadline' => '2025-03-24T23:59:59Z',
                'documents_count' => 2
            ]
            // ... more requests
        ],
        'total' => 45,
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

// List all service proof requests
$response = $api->serviceProofs->listServiceProofRequests(
    limit: 50
);

echo "Total requests: {$response->total}\n\n";
foreach ($response->requests as $request) {
    echo "ID: {$request->requestId}\n";
    echo "Purchase: {$request->purchaseId}\n";
    echo "Product: {$request->productName}\n";
    echo "Status: {$request->status}\n";
    echo "Deadline: {$request->deadline}\n";
    echo "Documents: {$request->documentsCount}\n\n";
}

// Filter by pending status
$response = $api->serviceProofs->listServiceProofRequests(
    status: 'pending'
);

echo "Pending requests: {$response->total}\n";

// Filter by product
$response = $api->serviceProofs->listServiceProofRequests(
    productId: 123
);

// Filter by date range
$response = $api->serviceProofs->listServiceProofRequests(
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid filter values or pagination parameters |

## Notes

- Status values: `pending`, `submitted`, `approved`, `rejected`
- Results ordered by request date (newest first)
- Max 500 results per request
- Use pagination for large result sets
- Typically required for digital services in certain jurisdictions
