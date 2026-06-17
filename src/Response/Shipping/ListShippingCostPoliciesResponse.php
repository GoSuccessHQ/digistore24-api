<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Shipping Cost Policies Response
 *
 * Response object for the Shipping API endpoint.
 */
final class ListShippingCostPoliciesResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $shippingCostPolicies = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $policiesData = $innerData['shipping_cost_policies'] ?? [];
        if (! is_array($policiesData)) {
            $policiesData = [];
        }
        /** @var array<string, mixed> $validatedPolicies */
        $validatedPolicies = $policiesData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->shippingCostPolicies = $validatedPolicies;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
