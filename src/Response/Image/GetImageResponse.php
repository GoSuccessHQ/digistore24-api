<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Image;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Image Response
 *
 * Response containing image details.
 */
final class GetImageResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Image ID
     */
    public string $imageId = '';

    /**
     * Image URL
     */
    public string $imageUrl = '';

    /**
     * Image name
     */
    public string $name = '';

    /**
     * Usage type
     */
    public ?string $usageType = null;

    /**
     * Alt tag
     */
    public ?string $altTag = null;

    /**
     * Creation timestamp
     */
    public ?\DateTimeInterface $createdAt = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->imageId = is_string($innerData['image_id'] ?? null) ? $innerData['image_id'] : '';
        $response->imageUrl = is_string($innerData['image_url'] ?? null) ? $innerData['image_url'] : '';
        $response->name = is_string($innerData['name'] ?? null) ? $innerData['name'] : '';
        $response->usageType = isset($innerData['usage_type']) && is_string($innerData['usage_type']) ? $innerData['usage_type'] : null;
        $response->altTag = isset($innerData['alt_tag']) && is_string($innerData['alt_tag']) ? $innerData['alt_tag'] : null;
        $response->createdAt = isset($innerData['created_at']) ? new \DateTimeImmutable(is_string($innerData['created_at']) ? $innerData['created_at'] : 'now') : null;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
