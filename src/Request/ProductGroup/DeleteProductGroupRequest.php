<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Delete Product Group Request
 *
 * Deletes an existing product group by its unique identifier.
 */
final class DeleteProductGroupRequest extends AbstractRequest
{
    /**
     * @param string $productGroupId The unique identifier of the product group to delete
     */
    public function __construct(private string $productGroupId)
    {
    }

    public function getEndpoint(): string
    {
        return '/deleteProductGroup';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function toArray(): array
    {
        return ['product_group_id' => $this->productGroupId];
    }
}
