<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Image;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Images Request
 *
 * Lists all images in the account.
 */
final class ListImagesRequest extends AbstractRequest
{
    public function __construct(
        public readonly ?string $usageType = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listImages';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
