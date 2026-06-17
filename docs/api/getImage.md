# getImage

Retrieves details of a specific image by its ID.

## Endpoint

**GET** `https://www.digistore24.com/api/call/getImage`

[OpenAPI spec](https://digistore24.com/api/docs/paths/getImage.yaml)

## Parameters

- `imageId` (string, required) — The unique identifier of the image to retrieve.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Image\GetImageRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new GetImageRequest(imageId: 'IMG12345');

$response = $ds24->images->get($request);

echo $response->id;    // e.g. "IMG12345"
echo $response->url;   // CDN URL to access the image
echo $response->type;  // e.g. "product"
```

## Response

`GetImageResponse` exposes typed public properties (the image details are returned under the `image` wrapper):

- `result` (string) — Result status returned by the API.
- `id` (?string) — Image ID.
- `url` (?string) — URL to access the image.
- `type` (?string) — Type of image.
- `properties` (array<string, mixed>) — Additional image properties (free-form map).
- `data` (array) — The complete image payload, accessible by key.

## Error Handling

```php
try {
    $response = $ds24->images->get($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createImage](createImage.md)
- [listImages](listImages.md)
- [deleteImage](deleteImage.md)
