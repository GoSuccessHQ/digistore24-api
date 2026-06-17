# getServiceProofRequest

Get service proof request details.

## Endpoint

```
POST /json/getServiceProofRequest
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `request_id` | int | Yes | Service proof request ID |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'request_id' => 456,
        'purchase_id' => 'ABCD1234',
        'buyer_email' => 'customer@example.com',
        'product_name' => 'Premium Course',
        'requested_at' => '2025-03-15T10:00:00Z',
        'status' => 'pending',
        'deadline' => '2025-03-29T23:59:59Z',
        'documents' => [
            [
                'document_id' => 789,
                'filename' => 'service_proof.pdf',
                'uploaded_at' => '2025-03-18T14:30:00Z',
                'size' => 245678
            ]
        ],
        'notes' => 'Customer requested service proof for tax purposes'
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

// Get service proof request details
$response = $api->serviceProofs->getServiceProofRequest(
    requestId: 456
);

echo "Request ID: {$response->requestId}\n";
echo "Purchase: {$response->purchaseId}\n";
echo "Product: {$response->productName}\n";
echo "Status: {$response->status}\n";
echo "Deadline: {$response->deadline}\n";

if (!empty($response->documents)) {
    echo "\nDocuments uploaded:\n";
    foreach ($response->documents as $doc) {
        echo "  - {$doc->filename} ({$doc->size} bytes)\n";
    }
}

if ($response->notes) {
    echo "\nNotes: {$response->notes}\n";
}
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid request ID |
| 404 | Request not found | Specified service proof request does not exist |
| 403 | Access denied | No permission to view this request |

## Notes

- Service proof required for certain products/countries
- Status values: `pending`, `submitted`, `approved`, `rejected`
- Typical deadline is 14 days from request date
- Documents can be uploaded via API or dashboard
