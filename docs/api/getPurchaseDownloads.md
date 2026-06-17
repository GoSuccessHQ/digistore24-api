# getPurchaseDownloads

Returns download information for purchased digital products, including URLs, download limits, access status, and file details.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getPurchaseDownloads`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getPurchaseDownloads.yaml)

## Parameters

Constructor arguments of `GetPurchaseDownloadsRequest`:

- `purchaseId` (string, required) — A single Digistore24 order ID or a comma-separated list of order IDs.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseDownloadsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetPurchaseDownloadsRequest(purchaseId: '12345678');

$response = $ds24->purchases->getDownloads($request);

foreach ($response->downloads as $purchaseId => $products) {
    foreach ($products as $productId => $files) {
        foreach ($files as $file) {
            echo $file['file_name'] ?? '';
            echo $file['url'] ?? '';
            echo $file['is_access_granted'] ?? ''; // "Y" or "N"
        }
    }
}
```

## Response

`GetPurchaseDownloadsResponse` exposes:

- `result` (string) — Result status returned by the API.
- `downloads` (array) — Download details keyed by purchase ID, then product ID. Each file entry contains keys such as `url`, `file_name`, `downloads_total`, `downloads_tries`, `is_access_granted`, and `is_purchase_paid`.

## Error Handling

```php
try {
    $response = $ds24->purchases->getDownloads($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchase](getPurchase.md)
- [getPurchaseTracking](getPurchaseTracking.md)
- [listPurchases](listPurchases.md)
