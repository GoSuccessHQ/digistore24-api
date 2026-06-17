# deleteImage

Deletes an image from Digistore24.

## Endpoint

**DELETE** `https://www.digistore24.com/api/call/deleteImage`

[OpenAPI spec](https://digistore24.com/api/docs/paths/deleteImage.yaml)

## Parameters

- `imageId` (string, required) — The unique identifier of the image to delete.

## Usage Example

```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\Image\DeleteImageRequest;

$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$request = new DeleteImageRequest(imageId: 'IMG12345');

$response = $ds24->images->delete($request);

echo $response->success ? 'deleted' : 'failed'; // bool
echo $response->imageId;                        // e.g. "IMG12345"
```

## Response

`DeleteImageResponse` exposes typed public properties:

- `result` (string) — Result status returned by the API.
- `success` (bool) — Whether the deletion was successful.
- `imageId` (string) — ID of the deleted image.
- `message` (?string) — Optional message returned by the API, or `null`.

## Error Handling

```php
try {
    $response = $ds24->images->delete($request);
} catch (ValidationException $e) {
    // request failed local validation; $e->getErrors() lists the problems
} catch (ApiException $e) {
    // API returned an error or the HTTP call failed
}
```

## Related Endpoints

- [createImage](createImage.md)
- [getImage](getImage.md)
- [listImages](listImages.md)
