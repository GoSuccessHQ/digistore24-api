# updateServiceProofRequest

Update a service proof request.

## Endpoint

```
POST /json/updateServiceProofRequest
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `request_id` | int | Yes | Service proof request ID |
| `status` | string | No | New status (submitted, approved, rejected) |
| `notes` | string | No | Additional notes |
| `document_url` | string | No | URL to uploaded document |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'request_id' => 456,
        'purchase_id' => 'ABCD1234',
        'status' => 'submitted',
        'notes' => 'Service proof documents uploaded',
        'updated_at' => '2025-03-20T23:00:00Z'
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

// Update status to submitted
$response = $api->serviceProofs->updateServiceProofRequest(
    requestId: 456,
    status: 'submitted'
);

echo "Request {$response->requestId} updated to: {$response->status}\n";

// Add notes
$response = $api->serviceProofs->updateServiceProofRequest(
    requestId: 456,
    notes: 'Service proof documents uploaded and verified'
);

// Approve request
$response = $api->serviceProofs->updateServiceProofRequest(
    requestId: 456,
    status: 'approved',
    notes: 'All documents verified and approved'
);

// Reject request
$response = $api->serviceProofs->updateServiceProofRequest(
    requestId: 456,
    status: 'rejected',
    notes: 'Incomplete documentation, please resubmit'
);

// Update with document URL
$response = $api->serviceProofs->updateServiceProofRequest(
    requestId: 456,
    status: 'submitted',
    documentUrl: 'https://example.com/docs/proof.pdf',
    notes: 'Service proof document attached'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid request ID or status |
| 404 | Request not found | Specified service proof request does not exist |
| 403 | Access denied | No permission to update this request |
| 409 | Invalid status transition | Cannot change from current status to requested status |

## Notes

- Valid status transitions: pending → submitted → approved/rejected
- Cannot change status once approved or rejected
- Notes are appended to request history
- Approved status releases any payment holds
- Rejected status may require resubmission
