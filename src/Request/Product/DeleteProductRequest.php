<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Product;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Request to delete a product
 *
 * @link https://digistore24.com/api/docs/paths/deleteProduct.yaml OpenAPI Specification
 */
final class DeleteProductRequest extends AbstractRequest
{
    /**
     * @param int $productId ID of the product to delete
     */
    public function __construct(
        public int $productId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/deleteProduct';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }
}
