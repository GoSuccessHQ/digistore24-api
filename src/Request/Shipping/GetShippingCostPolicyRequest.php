<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Shipping Cost Policy Request
 *
 * Retrieves detailed information about a specific shipping cost policy.
 */
final class GetShippingCostPolicyRequest extends AbstractRequest
{
    /**
     * @param string $shippingCostPolicyId The unique identifier of the shipping cost policy
     */
    public function __construct(private string $shippingCostPolicyId)
    {
    }

    public function getEndpoint(): string
    {
        return '/getShippingCostPolicy';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['policy_id' => $this->shippingCostPolicyId];
    }
}
