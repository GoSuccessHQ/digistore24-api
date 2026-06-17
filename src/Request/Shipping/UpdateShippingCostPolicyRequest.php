<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\ShippingCostPolicyData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Update Shipping Cost Policy Request
 *
 * Updates an existing shipping cost policy's configuration.
 */
final class UpdateShippingCostPolicyRequest extends AbstractRequest
{
    /**
     * @param string $shippingCostPolicyId The unique identifier of the shipping cost policy to update
     * @param ShippingCostPolicyData $policy The updated shipping cost policy configuration
     */
    public function __construct(private string $shippingCostPolicyId, private ShippingCostPolicyData $policy)
    {
    }

    public function getEndpoint(): string
    {
        return '/updateShippingCostPolicy';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        return array_merge(['shipping_cost_policy_id' => $this->shippingCostPolicyId], $this->policy->toArray());
    }
}
