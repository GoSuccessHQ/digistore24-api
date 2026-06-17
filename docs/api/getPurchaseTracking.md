# getPurchaseTracking

Returns tracking data for one or more orders, including UTM parameters, click IDs, sub IDs, vendor key, and campaign key.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getPurchaseTracking`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getPurchaseTracking.yaml)

## Parameters

Constructor arguments of `GetPurchaseTrackingRequest`:

- `purchaseId` (string, required) — A single Digistore24 order ID or a comma-separated list of order IDs.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseTrackingRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetPurchaseTrackingRequest(purchaseId: '12345678,23456789');

$response = $ds24->purchases->getTracking($request);

foreach ($response->tracking as $purchaseId => $data) {
    echo $purchaseId . "\n";
    echo $data['campaign_key'] ?? '';
    echo $data['vendor_key'] ?? '';
}
```

## Response

`GetPurchaseTrackingResponse` exposes:

- `result` (string) — Result status returned by the API.
- `tracking` (array) — Tracking data keyed by purchase ID. Read individual values via `$response->tracking[$purchaseId]['campaign_key']`, etc.

## Error Handling

```php
try {
    $response = $ds24->purchases->getTracking($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getPurchase](getPurchase.md)
- [listPurchases](listPurchases.md)
- [getPurchaseDownloads](getPurchaseDownloads.md)
