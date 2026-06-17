<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create Shipping Cost Policy Response
 *
 * Response object for the Shipping API endpoint.
 */
final class CreateShippingCostPolicyResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function getShippingCostPolicyId(): ?string
    {
        $value = $this->data['shipping_cost_policy_id'] ?? null;

        return is_string($value) ? $value : null;
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $validatedData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
