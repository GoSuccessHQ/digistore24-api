<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Shipping Cost Policy Response
 *
 * Response object for the Shipping API endpoint.
 */
final class GetShippingCostPolicyResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $shippingCostPolicy = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $policyData = $innerData['shipping_cost_policy'] ?? [];
        if (! is_array($policyData)) {
            $policyData = [];
        }
        /** @var array<string, mixed> $validatedPolicy */
        $validatedPolicy = $policyData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->shippingCostPolicy = $validatedPolicy;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
