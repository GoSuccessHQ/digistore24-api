# deleteUpsells

Deletes all upsell configurations for a specific product.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteUpsells`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteUpsells.yaml)

## Parameters

The request takes a single scalar constructor argument:

- `productId` (int, required) — The unique identifier of the product whose upsell configurations should be deleted.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Upsell\DeleteUpsellsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteUpsellsRequest(productId: 1234567);

$response = $ds24->upsells->delete($request);

if ($response->wasSuccessful()) {
    echo 'Upsell configuration deleted.';
}
```

## Response

`DeleteUpsellsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.

It also provides a helper method:

- `wasSuccessful()` (bool) — Returns `true` when `result` equals `"success"`.

## Error Handling

```php
try {
    $response = $ds24->upsells->delete($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getUpsells](getUpsells.md)
- [updateUpsells](updateUpsells.md)
