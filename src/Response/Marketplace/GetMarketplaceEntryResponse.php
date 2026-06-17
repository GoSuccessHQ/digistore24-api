<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Marketplace;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Marketplace Entry Response
 *
 * Response object for the Marketplace API endpoint.
 */
final class GetMarketplaceEntryResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Marketplace entry data
     *
     * @var array<string, mixed>
     */
    public array $data = [];

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
