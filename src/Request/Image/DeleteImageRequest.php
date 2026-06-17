<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Image;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Delete Image Request
 *
 * Deletes an image from Digistore24.
 */
final class DeleteImageRequest extends AbstractRequest
{
    public function __construct(
        public readonly string $imageId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/deleteImage';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }
}
