<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Delete Shipping Cost Policy Request
 *
 * Deletes an existing shipping cost policy by its unique identifier.
 */
final class DeleteShippingCostPolicyRequest extends AbstractRequest
{
    /**
     * @param string $shippingCostPolicyId The unique identifier of the shipping cost policy to delete
     */
    public function __construct(private string $shippingCostPolicyId)
    {
    }

    public function getEndpoint(): string
    {
        return '/deleteShippingCostPolicy';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function toArray(): array
    {
        return ['policy_id' => $this->shippingCostPolicyId];
    }
}
