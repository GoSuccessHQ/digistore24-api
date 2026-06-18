<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Upsell;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Update Upsells Request
 *
 * Updates the upsell configuration for a specific product.
 */
final class UpdateUpsellsRequest extends AbstractRequest
{
    /**
     * @param int $productId The unique identifier of the product
     * @param array<string, mixed> $data The upsell configuration (upsell products, order, conditions, etc.)
     */
    public function __construct(private int $productId, private array $data)
    {
    }

    public function getEndpoint(): string
    {
        return '/updateUpsells';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return ['product_id' => $this->productId, 'data' => $this->data];
    }
}
