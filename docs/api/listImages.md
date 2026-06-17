# listImages

Lists all images in the account, optionally filtered by usage type.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listImages`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listImages.yaml)

## Parameters

- `usageType` (string, optional) — Filter images by their purpose (e.g. `product`). Defaults to `null` (all images).

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Image\ListImagesRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new ListImagesRequest(usageType: 'product');

$response = $ds24->images->list($request);

echo $response->totalCount; // e.g. 2

foreach ($response->images as $image) {
    echo $image->imageId;   // e.g. "05CZEP6G"
    echo $image->name;      // e.g. "Product Main Image"
    echo $image->imageUrl;  // CDN URL
}
```

The request is optional. Call `$ds24->images->list()` with no arguments to list every image.

## Response

`ListImagesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `images` (array of `ImageListItem`) — The image entries. Each `ImageListItem` exposes:
  - `imageId` (string) — Image ID.
  - `imageUrl` (string) — CDN URL to access the image.
  - `name` (string) — Image name.
  - `usageType` (?string) — Purpose of the image, or `null`.
  - `createdAt` (\DateTimeInterface) — Creation timestamp.
- `totalCount` (int) — Total number of images returned.

## Error Handling

```php
try {
    $response = $ds24->images->list($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createImage](createImage.md)
- [getImage](getImage.md)
- [deleteImage](deleteImage.md)
