<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Product;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Enum\ProductSortBy;

/**
 * List Products Request
 *
 * Lists all products in the account.
 */
final class ListProductsRequest extends AbstractRequest
{
    /**
     * @param ProductSortBy $sortBy Sort products by name or product group
     */
    public function __construct(
        public readonly ProductSortBy $sortBy = ProductSortBy::NAME,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listProducts';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
