<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Upsell;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Upsells Response
 *
 * Response object for the Upsell API endpoint.
 */
final class GetUpsellsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $upsells = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $upsells = $innerData['upsells'] ?? [];

        if (! is_array($upsells)) {
            $upsells = [];
        }

        /** @var array<string, mixed> $validatedUpsells */
        $validatedUpsells = $upsells;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->upsells = $validatedUpsells;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
