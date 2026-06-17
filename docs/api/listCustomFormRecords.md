# listCustomFormRecords

List custom form records.

## Endpoint

```
POST /json/listCustomFormRecords
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `form_id` | int | Yes | Custom form ID |
| `start_date` | string | No | Start date (Y-m-d) |
| `end_date` | string | No | End date (Y-m-d) |
| `limit` | int | No | Results per page (default: 100, max: 500) |
| `offset` | int | No | Pagination offset |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'form_id' => 123,
        'form_name' => 'Customer Survey',
        'records' => [
            [
                'record_id' => 456,
                'purchase_id' => 'ABCD1234',
                'buyer_email' => 'customer@example.com',
                'submitted_at' => '2025-03-15T10:30:00Z',
                'fields' => [
                    [
                        'field_name' => 'company',
                        'field_label' => 'Company Name',
                        'value' => 'Example Corp'
                    ],
                    [
                        'field_name' => 'phone',
                        'field_label' => 'Phone Number',
                        'value' => '+49 30 12345678'
                    ],
                    [
                        'field_name' => 'feedback',
                        'field_label' => 'Your Feedback',
                        'value' => 'Great product, very satisfied!'
                    ]
                ]
            ],
            [
                'record_id' => 457,
                'purchase_id' => 'EFGH5678',
                'buyer_email' => 'buyer@example.com',
                'submitted_at' => '2025-03-16T14:00:00Z',
                'fields' => [
                    [
                        'field_name' => 'company',
                        'field_label' => 'Company Name',
                        'value' => 'Test Inc'
                    ],
                    [
                        'field_name' => 'phone',
                        'field_label' => 'Phone Number',
                        'value' => '+1 555 0123'
                    ],
                    [
                        'field_name' => 'feedback',
                        'field_label' => 'Your Feedback',
                        'value' => 'Good service'
                    ]
                ]
            ]
            // ... more records
        ],
        'total' => 87,
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

// List all records for a form
$response = $api->customForms->listCustomFormRecords(
    formId: 123,
    limit: 50
);

echo "Form: {$response->formName}\n";
echo "Total records: {$response->total}\n\n";

foreach ($response->records as $record) {
    echo "Record ID: {$record->recordId}\n";
    echo "Purchase: {$record->purchaseId}\n";
    echo "Buyer: {$record->buyerEmail}\n";
    echo "Submitted: {$record->submittedAt}\n\n";
    
    echo "Fields:\n";
    foreach ($record->fields as $field) {
        echo "  {$field->fieldLabel}: {$field->value}\n";
    }
    echo "\n";
}

// Filter by date range
$response = $api->customForms->listCustomFormRecords(
    formId: 123,
    startDate: '2025-01-01',
    endDate: '2025-12-31'
);

// Pagination
$response = $api->customForms->listCustomFormRecords(
    formId: 123,
    limit: 20,
    offset: 0
);

// Export to CSV
$response = $api->customForms->listCustomFormRecords(
    formId: 123
);

$csv = fopen('form_records.csv', 'w');

// Write header
$header = ['Record ID', 'Purchase ID', 'Buyer Email', 'Submitted At'];
if (!empty($response->records)) {
    foreach ($response->records[0]->fields as $field) {
        $header[] = $field->fieldLabel;
    }
}
fputcsv($csv, $header);

// Write data
foreach ($response->records as $record) {
    $row = [
        $record->recordId,
        $record->purchaseId,
        $record->buyerEmail,
        $record->submittedAt
    ];
    
    foreach ($record->fields as $field) {
        $row[] = $field->value;
    }
    
    fputcsv($csv, $row);
}

fclose($csv);
echo "Exported {$response->total} records to form_records.csv\n";
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid form ID or date format |
| 404 | Form not found | Specified custom form does not exist |
| 403 | Access denied | No permission to view this form's records |

## Notes

- Custom forms collect additional information during checkout
- Results ordered by submission date (newest first)
- Max 500 results per request
- Use pagination for large result sets
- Use for customer data collection and analysis
- Can be exported to CSV for further processing
