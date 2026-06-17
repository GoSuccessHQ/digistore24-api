# listImages

Lists all images in the account, optionally filtered by usage type.

## Endpoint

**GET** `https://www.digistore24.com/api/call/listImages`

[OpenAPI spec](https://digistore24.com/api/docs/paths/listImages.yaml)

## Parameters

- `usageType` (string, required by the API) — Purpose of the images to list (e.g. `product`). See `getGlobalSettings()` `image_usage_type`. Defaults to `null`.

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
    echo $image->id;             // e.g. "05CZEP6G"
    echo $image->name;           // e.g. "Product Main Image"
    echo $image->url;            // CDN URL
    echo $image->fileExtension;  // e.g. "png"
}
```

## Response

`ListImagesResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `images` (array of `ImageListItem`) — The image entries. Each `ImageListItem` exposes:
  - `id` (string) — Unique image identifier.
  - `url` (string) — Full CDN image URI.
  - `fileExtension` (string) — Image format (e.g. `png`).
  - `name` (string) — Image name/label.
  - `approvalStatus` (?string) — Moderation state (e.g. `approved`).
  - `usageType` (?string) — Categorized purpose (e.g. `product`).
  - `altTag` (?string) — Accessibility text, or `null`.
  - `width` (?int) — Image width in pixels.
  - `height` (?int) — Image height in pixels.
- `totalCount` (int) — Number of images returned (convenience count; not a spec field).

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
