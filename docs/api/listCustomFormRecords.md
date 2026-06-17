# listCustomFormRecords

Returns a list with data from additional input fields collected during the checkout process.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listCustomFormRecords`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listCustomFormRecords.yaml)

## Parameters

- `purchaseId` (string, optional) — Restrict the result to records of a single purchase. When omitted, all available records are returned.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\CustomForm\ListCustomFormRecordsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

// The request argument is optional; $ds24->customForms->listRecords() works as well.
$request = new ListCustomFormRecordsRequest(purchaseId: 'ABCDEF12');

$response = $ds24->customForms->listRecords($request);

foreach ($response->records as $record) {
    echo $record->purchaseId;     // e.g. "ABCDEF12"
    echo $record->productId;      // e.g. 4711

    // $record->data holds the submitted field values keyed by field name.
    foreach ($record->data as $field => $value) {
        echo "{$field}: {$value}";
    }
}

// Convenience helper to filter the records by purchase ID.
$forPurchase = $response->getRecordsByPurchaseId('ABCDEF12');
```

## Response

`ListCustomFormRecordsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `records` (array of objects) — The custom form records. Each record is a stdClass object with properties: `form_id` (int), `id` (int), `purchase_id` (string), `purchase_item_id` (int), `product_id` (int), `form_no` (int), `form_count` (int), `data` (array of field name => value), and `address` (array of address fields).

The convenience method `getRecordsByPurchaseId(string $purchaseId)` returns only the records belonging to the given purchase.

## Error Handling

```php
try {
    $response = $ds24->customForms->listRecords($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [listInvoices](listInvoices.md)
