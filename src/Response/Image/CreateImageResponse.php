<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Image;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create Image Response
 *
 * Response after successfully creating an image.
 */
final class CreateImageResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * ID of the created image
     */
    public string $imageId = '';

    /**
     * URL of the created image on Digistore24
     */
    public string $imageUrl = '';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->imageId = is_string($innerData['image_id'] ?? null) ? $innerData['image_id'] : '';
        $response->imageUrl = is_string($innerData['image_url'] ?? null) ? $innerData['image_url'] : '';

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
