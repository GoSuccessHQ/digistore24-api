<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Image;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Image Response
 *
 * Response for getImage. The image details are returned under the `image`
 * wrapper as `id`, `url`, `type` and a free-form `properties` map.
 *
 * @link https://digistore24.com/api/docs/paths/getImage.yaml
 */
final class GetImageResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Image ID (spec key: image.id).
     */
    public ?string $id = null;

    /**
     * URL to access the image (spec key: image.url).
     */
    public ?string $url = null;

    /**
     * Type of image (spec key: image.type).
     */
    public ?string $type = null;

    /**
     * Additional image properties (free-form map).
     *
     * @var array<string, mixed>
     */
    public array $properties = [];

    /**
     * The complete image payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        // The image details live under the `image` wrapper; fall back to the
        // inner data itself for payloads that are already unwrapped.
        $imageData = $innerData['image'] ?? $innerData;
        if (! is_array($imageData)) {
            $imageData = [];
        }
        /** @var array<string, mixed> $validatedImage */
        $validatedImage = $imageData;

        $properties = $validatedImage['properties'] ?? [];
        if (! is_array($properties)) {
            $properties = [];
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->id = TypeConverter::toString($validatedImage['id'] ?? null);
        $response->url = TypeConverter::toString($validatedImage['url'] ?? null);
        $response->type = TypeConverter::toString($validatedImage['type'] ?? null);
        /** @var array<string, mixed> $properties */
        $response->properties = $properties;
        $response->data = $validatedImage;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
