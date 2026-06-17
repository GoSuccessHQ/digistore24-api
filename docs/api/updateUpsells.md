# updateUpsells

Updates the upsell configuration for a specific product.

## Endpoint

**PUT** `https://www.digistore24.com/api/call/updateUpsells`

[OpenAPI spec](https://digistore24.com/api/docs/paths/updateUpsells.yaml)

## Parameters

The request takes scalar constructor arguments:

- `productId` (int, required) — The unique identifier of the product to update.
- `data` (array, required) — The upsell configuration (upsell products, order, conditions, etc.). The keys are merged into the request alongside `product_id`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Upsell\UpdateUpsellsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new UpdateUpsellsRequest(
    productId: 1234567,
    data: [
        'upsells' => [
            ['product_id' => 2345678, 'position' => 1],
            ['product_id' => 3456789, 'position' => 2],
        ],
    ],
);

$response = $ds24->upsells->update($request);

if ($response->wasSuccessful()) {
    echo 'Upsell configuration updated.';
}
```

## Response

`UpdateUpsellsResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `isModified` (?bool) — Whether the upsell tree was changed.

It also provides a helper method:

- `wasSuccessful()` (bool) — Returns `true` when `result` equals `"success"`.

## Error Handling

```php
try {
    $response = $ds24->upsells->update($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getUpsells](getUpsells.md)
- [deleteUpsells](deleteUpsells.md)
