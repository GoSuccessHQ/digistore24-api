<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Marketplace;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\MarketplaceEntryData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Marketplace Entries Response
 *
 * Response containing a list of marketplace entries. Each entry exposes the spec
 * fields (id, headline, price, stats_*, ...) as a typed DTO.
 *
 * @link https://digistore24.com/api/docs/paths/listMarketplaceEntries.yaml
 */
final class ListMarketplaceEntriesResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Marketplace entries
     *
     * @var array<int, MarketplaceEntryData>
     */
    public array $entries = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $entriesData = $innerData['entries'] ?? [];

        $entries = [];
        if (is_array($entriesData)) {
            foreach ($entriesData as $entryItem) {
                if (! is_array($entryItem)) {
                    continue;
                }
                /** @var array<string, mixed> $validEntryItem */
                $validEntryItem = $entryItem;
                $entries[] = MarketplaceEntryData::fromArray($validEntryItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->entries = $entries;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
