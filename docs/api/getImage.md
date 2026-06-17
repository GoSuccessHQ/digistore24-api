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

echo $response->name;      // e.g. "Product Main Image"
echo $response->imageUrl;  // e.g. "https://www.digistore24.com/images/IMG12345.jpg"
echo $response->usageType; // e.g. "product"
```

## Response

`GetImageResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `imageId` (string) — Image ID.
- `imageUrl` (string) — URL to access the image.
- `name` (string) — Image name.
- `usageType` (?string) — Purpose of the image, or `null`.
- `altTag` (?string) — Alternative text, or `null`.
- `createdAt` (?\DateTimeInterface) — Creation timestamp, or `null`.

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
