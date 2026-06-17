<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Product;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Product Request
 *
 * Retrieves details of a specific product.
 */
final class GetProductRequest extends AbstractRequest
{
    public function __construct(
        public readonly string $productId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/getProduct';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
