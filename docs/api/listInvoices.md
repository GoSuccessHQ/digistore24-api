# listInvoices

List all invoices with optional filters.

## Endpoint

```
POST /json/listInvoices
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `purchase_id` | string | No | Filter by purchase ID |
| `buyer_email` | string | No | Filter by buyer email |
| `start_date` | string | No | Filter invoices from date (Y-m-d) |
| `end_date` | string | No | Filter invoices to date (Y-m-d) |
| `limit` | int | No | Number of results (default: 100, max: 1000) |
| `offset` | int | No | Offset for pagination |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'invoices' => [
            [
                'invoice_id' => 'INV-2025-12345',
                'invoice_number' => 'RE-2025-12345',
                'purchase_id' => 'ABC123XYZ',
                'buyer_email' => 'buyer@example.com',
                'amount' => 149.99,
                'currency' => 'EUR',
                'vat_amount' => 23.85,
                'created_at' => '2025-10-15 10:00:00',
                'pdf_url' => 'https://...'
            ],
            // ... more invoices
        ],
        'total' => 1500,
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

// List all invoices
$response = $api->invoices->listInvoices(
    limit: 50
);

foreach ($response->invoices as $invoice) {
    echo "Invoice {$invoice->invoiceNumber}: € {$invoice->amount}\n";
    echo "PDF: {$invoice->pdfUrl}\n";
}

// Filter by date range
$response = $api->invoices->listInvoices(
    startDate: '2025-01-01',
    endDate: '2025-12-31',
    limit: 100
);

// Get invoices for specific buyer
$response = $api->invoices->listInvoices(
    buyerEmail: 'buyer@example.com'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Invalid parameters | Invalid date format or parameters |

## Notes

- Results ordered by creation date (newest first)
- PDF URLs are temporary and expire after 24 hours
- Use pagination for large result sets
- Maximum 1000 results per request
- Includes VAT breakdown for tax reporting
