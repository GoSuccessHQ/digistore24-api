# listInvoices

Retrieves all invoices for a specific purchase.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listInvoices`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listInvoices.yaml)

## Parameters

- `purchaseId` (string, required) — The ID of the purchase whose invoices should be listed.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Invoice\ListInvoicesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListInvoicesRequest(purchaseId: 'ABCDEF12');

$response = $ds24->invoices->list($request);

echo $response->purchaseId; // e.g. "ABCDEF12"

foreach ($response->invoiceList as $invoice) {
    // Each entry is an associative array as returned by the API.
    echo $invoice['invoice_no'] ?? '';
    echo $invoice['amount'] ?? '';
}
```

## Response

`ListInvoicesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `purchaseId` (string) — The purchase ID the invoices belong to.
- `invoiceList` (array) — The list of invoices. Each item is an associative array; read individual fields via `$invoice['key']`.

## Error Handling

```php
try {
    $response = $ds24->invoices->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [resendInvoiceMail](resendInvoiceMail.md)
