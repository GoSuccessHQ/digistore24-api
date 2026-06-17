<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\ProductGroupData;

/**
 * Create Product Group Request
 *
 * Creates a new product group for organizing related products.
 */
final class CreateProductGroupRequest extends AbstractRequest
{
    /**
     * @param ProductGroupData $productGroup The product group configuration
     */
    public function __construct(private ProductGroupData $productGroup)
    {
    }

    public function getEndpoint(): string
    {
        return '/createProductGroup';
    }

    public function toArray(): array
    {
        return $this->productGroup->toArray();
    }
}
