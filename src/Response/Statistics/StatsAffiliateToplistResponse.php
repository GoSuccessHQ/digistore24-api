<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\AffiliateToplistItemData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stats Affiliate Toplist Response
 *
 * Response for statsAffiliateToplist. Exposes the ranked affiliates under
 * `topList` (spec key: data.top_list) as typed {@see AffiliateToplistItemData}.
 *
 * @link https://digistore24.com/api/docs/paths/statsAffiliateToplist.yaml
 */
final class StatsAffiliateToplistResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The ranked affiliate entries as typed DTOs.
     *
     * @var array<int, AffiliateToplistItemData>
     */
    public array $topList = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        // Spec key is `top_list`; fall back to the legacy `toplist` shape.
        $items = $innerData['top_list'] ?? $innerData['toplist'] ?? [];
        if (! is_array($items)) {
            $items = [];
        }

        $topList = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }
            /** @var array<string, mixed> $validatedItem */
            $validatedItem = $item;
            $topList[] = AffiliateToplistItemData::fromArray($validatedItem);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->topList = $topList;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
