<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\ShippingCostPolicyListItemData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Shipping Cost Policies Response
 *
 * Response containing the list of shipping cost policies. The spec returns a
 * bare JSON array; each item is exposed as a {@see ShippingCostPolicyListItemData}.
 *
 * @link https://digistore24.com/api/docs/paths/listShippingCostPolicies.yaml
 */
final class ListShippingCostPoliciesResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The shipping cost policies as typed DTOs.
     *
     * @var array<int, ShippingCostPolicyListItemData>
     */
    public array $shippingCostPolicies = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        // The spec returns a bare array; older payloads wrap the list under the
        // `shipping_cost_policies` key. Support both shapes.
        $policiesData = $innerData['shipping_cost_policies'] ?? $innerData;
        if (! is_array($policiesData)) {
            $policiesData = [];
        }

        $policies = [];
        foreach ($policiesData as $item) {
            if (! is_array($item)) {
                continue;
            }
            /** @var array<string, mixed> $validatedItem */
            $validatedItem = $item;
            $policies[] = ShippingCostPolicyListItemData::fromArray($validatedItem);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->shippingCostPolicies = $policies;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
