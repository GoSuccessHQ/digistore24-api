# resendInvoiceMail

Resends the invoice email to the customer of a purchase.

## Endpoint

**POST** `https://www.digistore24.com/api/call/resendInvoiceMail`

[OpenAPI spec](https://digistore24.com/api/docs/paths/resendInvoiceMail.yaml)

## Parameters

- `purchaseId` (string, required) — The ID of the purchase whose invoice email should be resent.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Invoice\ResendInvoiceMailRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ResendInvoiceMailRequest(purchaseId: 'ABCDEF12');

$response = $ds24->invoices->resendMail($request);

echo $response->status; // e.g. "success"
echo $response->note;   // human-readable note from the API
```

## Response

`ResendInvoiceMailResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `status` (string) — Status of the resend operation.
- `note` (string) — Human-readable note from the API.

## Error Handling

```php
try {
    $response = $ds24->invoices->resendMail($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listInvoices](listInvoices.md)
