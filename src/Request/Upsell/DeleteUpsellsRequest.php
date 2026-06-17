<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Upsell;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Delete Upsells Request
 *
 * Deletes all upsell configurations for a specific product.
 */
final class DeleteUpsellsRequest extends AbstractRequest
{
    /**
     * @param int $productId The unique identifier of the product
     */
    public function __construct(private int $productId)
    {
    }

    public function getEndpoint(): string
    {
        return '/deleteUpsells';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function toArray(): array
    {
        return ['product_id' => $this->productId];
    }
}
