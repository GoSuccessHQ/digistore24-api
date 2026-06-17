<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Image;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Images Response
 *
 * Response containing a list of images.
 */
final class ListImagesResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Array of image list items
     *
     * @var array<ImageListItem>
     */
    public array $images = [];

    /**
     * Total number of images
     */
    public int $totalCount = 0;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $images = [];
        if (isset($innerData['images']) && is_array($innerData['images'])) {
            foreach ($innerData['images'] as $image) {
                if (is_array($image)) {
                    /** @var array<string, mixed> $validatedImage */
                    $validatedImage = $image;
                    $images[] = ImageListItem::fromArray($validatedImage);
                }
            }
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
