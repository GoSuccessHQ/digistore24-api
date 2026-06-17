# resendInvoiceMail

Resend invoice email to customer.

## Endpoint

```
POST /json/resendInvoiceMail
```

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `invoice_id` | string | Yes | Invoice ID |
| `email` | string | No | Alternative email address (default: original buyer email) |

## Response

```php
[
    'result' => 'success',
    'data' => [
        'invoice_id' => 'INV-2025-12345',
        'sent_to' => 'buyer@example.com',
        'sent_at' => '2025-10-15 14:30:00'
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

// Resend to original email
$response = $api->invoices->resendInvoiceMail(
    invoiceId: 'INV-2025-12345'
);

echo "Invoice resent to: {$response->sentTo}\n";

// Send to alternative email
$response = $api->invoices->resendInvoiceMail(
    invoiceId: 'INV-2025-12345',
    email: 'accounting@example.com'
);
```

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 404 | Invoice not found | Invoice ID does not exist |
| 400 | Invalid email | Email format is invalid |
| 403 | Access denied | Not authorized to resend this invoice |

## Notes

- Invoice is sent as PDF attachment
- Use for customer service when invoice was not received
- Alternative email useful for accounting departments
- Original buyer email is used if no email specified
