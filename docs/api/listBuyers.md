# listBuyers

Retrieves a paginated list of all buyers.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listBuyers`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listBuyers.yaml)

## Parameters

`ListBuyersRequest` takes the following optional constructor arguments. Both default to `null`, in which case the API applies its own defaults.

- `pageNo` (int, optional) — Page number, starting at 1.
- `pageSize` (int, optional) — Number of buyers per page.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Buyer\ListBuyersRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListBuyersRequest(pageNo: 1, pageSize: 50);

$response = $ds24->buyers->list($request);

echo $response->total;  // e.g. 327

foreach ($response->buyers as $buyer) {
    echo $buyer->id . ': ' . $buyer->email . PHP_EOL;
}
```

The request is optional. Calling `$ds24->buyers->list()` with no arguments returns the first page using the API defaults.

## Response

`ListBuyersResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `buyers` (`BuyerData[]`) — The buyers on this page. Each `BuyerData` exposes `id`, `email`, `firstName`, `lastName`, `company`, `country`, and related fields.
- `total` (int) — Total number of buyers available.
- `limit` (int) — Result limit that was applied.
- `offset` (int) — Result offset that was applied.

## Error Handling

```php
try {
    $response = $ds24->buyers->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getBuyer](getBuyer.md)
- [updateBuyer](updateBuyer.md)
