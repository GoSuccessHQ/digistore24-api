<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\ProductGroupData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Update Product Group Request
 *
 * Updates an existing product group's configuration.
 */
final class UpdateProductGroupRequest extends AbstractRequest
{
    /**
     * @param string $productGroupId The unique identifier of the product group to update
     * @param ProductGroupData $productGroup The updated product group configuration
     */
    public function __construct(private string $productGroupId, private ProductGroupData $productGroup)
    {
    }

    public function getEndpoint(): string
    {
        return '/updateProductGroup';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        return array_merge(['product_group_id' => $this->productGroupId], $this->productGroup->toArray());
    }
}
