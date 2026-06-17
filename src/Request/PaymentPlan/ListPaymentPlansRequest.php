<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Payment Plans Request
 *
 * Retrieves the list of payment plans configured for a product.
 *
 * @link https://digistore24.com/api/docs/paths/listPaymentPlans.yaml
 */
final class ListPaymentPlansRequest extends AbstractRequest
{
    /**
     * @param int $productId The Digistore24 product ID whose payment plans to list
     */
    public function __construct(private int $productId)
    {
    }

    public function getEndpoint(): string
    {
        return '/listPaymentPlans';
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
