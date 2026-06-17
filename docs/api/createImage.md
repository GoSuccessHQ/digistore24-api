# createImage

Creates an image on Digistore24 by providing a URL to copy from.

## Endpoint

**POST** `https://www.digistore24.com/api/call/createImage`

[OpenAPI spec](https://digistore24.com/api/docs/paths/createImage.yaml)

## Parameters

- `name` (string, required) — Name of the image. Must not exceed 63 characters.
- `imageUrl` (string, required) — Publicly accessible URL from which Digistore24 copies the image.
- `usageType` (string, optional) — Purpose of the image (e.g. `product`). Defaults to `null`.
- `altTag` (string, optional) — Alternative text for the image. Defaults to `null`.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Image\CreateImageRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new CreateImageRequest(
    name: 'Product Main Image',
    imageUrl: 'https://example.com/images/product.jpg',
    usageType: 'product',
    altTag: 'Premium product photo',
);

$response = $ds24->images->create($request);

echo $response->imageId;  // e.g. "IMG12345"
echo $response->imageUrl; // e.g. "https://www.digistore24.com/images/IMG12345.jpg"
```

## Response

`CreateImageResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `imageId` (string) — ID of the created image on Digistore24.
- `imageUrl` (string) — URL of the created image on Digistore24 servers.

## Error Handling

```php
try {
    $response = $ds24->images->create($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [getImage](getImage.md)
- [listImages](listImages.md)
- [deleteImage](deleteImage.md)
