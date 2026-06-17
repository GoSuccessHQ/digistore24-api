<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Upsell;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Upsells Request
 *
 * Retrieves all upsell configurations for a specific product.
 */
final class GetUpsellsRequest extends AbstractRequest
{
    /**
     * @param int $productId The unique identifier of the product
     */
    public function __construct(private int $productId)
    {
    }

    public function getEndpoint(): string
    {
        return '/getUpsells';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['product_id' => $this->productId];
    }
}
