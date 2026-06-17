<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Product Group Request
 *
 * Retrieves detailed information about a specific product group.
 */
final class GetProductGroupRequest extends AbstractRequest
{
    /**
     * @param string $productGroupId The unique identifier of the product group
     */
    public function __construct(private string $productGroupId)
    {
    }

    public function getEndpoint(): string
    {
        return '/getProductGroup';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['product_group_id' => $this->productGroupId];
    }
}
