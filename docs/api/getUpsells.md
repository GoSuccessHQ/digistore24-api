# getUpsells

Retrieves the upsell configuration for a specific product.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getUpsells`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getUpsells.yaml)

## Parameters

The request takes a single scalar constructor argument:

- `productId` (int, required) — The unique identifier of the product whose upsell configuration should be returned.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Upsell\GetUpsellsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetUpsellsRequest(productId: 1234567);

$response = $ds24->upsells->get($request);

echo $response->result; // e.g. "success"

foreach ($response->upsells as $key => $value) {
    // inspect the upsell configuration entries
}
```

## Response

`GetUpsellsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `upsells` (array) — The upsell configuration for the product. Read as `$response->upsells['key']`.

## Error Handling

```php
try {
    $response = $ds24->upsells->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [updateUpsells](updateUpsells.md)
- [deleteUpsells](deleteUpsells.md)
