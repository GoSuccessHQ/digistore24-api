<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Shipping Cost Policy Response
 *
 * Response containing the details of a single shipping cost policy.
 *
 * @link https://digistore24.com/api/docs/paths/getShippingCostPolicy.yaml
 */
final class GetShippingCostPolicyResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The shipping cost policy data record.
     *
     * The spec returns it under the `policy` key; the legacy
     * `shipping_cost_policy` key is also accepted for compatibility.
     *
     * @var array<string, mixed>
     */
    public array $policy = [];

    /**
     * Alias of {@see $policy} kept for backward compatibility.
     *
     * @var array<string, mixed>
     */
    public array $shippingCostPolicy = [];

    /**
     * The complete response payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $policyData = $innerData['policy'] ?? $innerData['shipping_cost_policy'] ?? [];
        if (! is_array($policyData)) {
            $policyData = [];
        }
        /** @var array<string, mixed> $validatedPolicy */
        $validatedPolicy = $policyData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->policy = $validatedPolicy;
        $response->shippingCostPolicy = $validatedPolicy;
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
