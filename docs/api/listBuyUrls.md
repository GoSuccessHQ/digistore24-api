# listBuyUrls

Retrieves a list of all generated buy URLs across all products.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listBuyUrls`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listBuyUrls.yaml)

## Parameters

`ListBuyUrlsRequest` takes no parameters.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\BuyUrl\ListBuyUrlsRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$response = $ds24->buyUrls->list(new ListBuyUrlsRequest());

foreach ($response->items as $buyUrl) {
    echo $buyUrl->id . ': ' . $buyUrl->url . PHP_EOL;
    echo 'Product: ' . $buyUrl->productId . PHP_EOL;
    echo 'Created: ' . $buyUrl->createdAt?->format('Y-m-d H:i:s') . PHP_EOL;
}
```

## Response

`ListBuyUrlsResponse` exposes a typed public property:

- `items` (`BuyUrlData[]`) — The buy URLs. Each `BuyUrlData` exposes `id` (int), `productId` (int|null), `url` (string), `createdAt` (`DateTimeInterface`|null), and `modifiedAt` (`DateTimeInterface`|null).

## Error Handling

```php
try {
    $response = $ds24->buyUrls->list(new ListBuyUrlsRequest());
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createBuyUrl](createBuyUrl.md)
- [deleteBuyUrl](deleteBuyUrl.md)
