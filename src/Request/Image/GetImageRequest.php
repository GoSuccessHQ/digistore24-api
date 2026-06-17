<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Image;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Image Request
 *
 * Retrieves details of a specific image by its ID.
 */
final class GetImageRequest extends AbstractRequest
{
    public function __construct(
        public readonly string $imageId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/getImage';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
