<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Marketplace;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Marketplace Entries Response
 *
 * Response object for the Marketplace API endpoint.
 */
final class ListMarketplaceEntriesResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Marketplace entries
     *
     * @var array<string, mixed>
     */
    public array $entries = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $entriesData = $innerData['entries'] ?? [];
        if (! is_array($entriesData)) {
            $entriesData = [];
        }
        /** @var array<string, mixed> $validatedEntries */
        $validatedEntries = $entriesData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->entries = $validatedEntries;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
