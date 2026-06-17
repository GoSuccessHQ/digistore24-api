<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Shipping;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Shipping Cost Policy Response
 *
 * Response containing the ID of the newly created shipping cost policy.
 *
 * @link https://digistore24.com/api/docs/paths/createShippingCostPolicy.yaml
 */
final class CreateShippingCostPolicyResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * ID of the created shipping cost policy
     */
    public ?int $policyId = null;

    /**
     * The complete response payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->policyId = TypeConverter::toInt($innerData['policy_id'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
