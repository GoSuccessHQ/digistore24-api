# deleteBuyUrl

Deletes a previously generated buy URL. The deletion is permanent and does not affect orders already placed through that URL.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteBuyUrl`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteBuyUrl.yaml)

## Parameters

`DeleteBuyUrlRequest` takes the following constructor argument:

- `id` (int, required) — The ID of the buy URL to delete. Must be greater than 0.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\BuyUrl\DeleteBuyUrlRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteBuyUrlRequest(id: 342033068);

$response = $ds24->buyUrls->delete($request);

echo $response->result; // e.g. "success"
```

## Response

`DeleteBuyUrlResponse` exposes a typed public property:

- `result` (string) — Result status returned by the API.

## Error Handling

```php
try {
    $response = $ds24->buyUrls->delete($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createBuyUrl](createBuyUrl.md)
- [listBuyUrls](listBuyUrls.md)
