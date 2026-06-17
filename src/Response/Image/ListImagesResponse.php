<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Image;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Images Response
 *
 * Response for listImages. The images are returned under `images`, each exposed
 * as an {@see ImageListItem}.
 *
 * @link https://digistore24.com/api/docs/paths/listImages.yaml
 */
final class ListImagesResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The images as typed list items.
     *
     * @var array<int, ImageListItem>
     */
    public array $images = [];

    /**
     * Number of images returned (convenience count; not a spec field).
     */
    public int $totalCount = 0;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $imagesData = $innerData['images'] ?? [];
        if (! is_array($imagesData)) {
            $imagesData = [];
        }

        $images = [];
        foreach ($imagesData as $image) {
            if (! is_array($image)) {
                continue;
            }
            /** @var array<string, mixed> $validatedImage */
            $validatedImage = $image;
            $images[] = ImageListItem::fromArray($validatedImage);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->images = $images;
        $response->totalCount = is_int($innerData['total_count'] ?? null) ? $innerData['total_count'] : count($images);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
