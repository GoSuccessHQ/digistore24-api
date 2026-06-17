<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Commission;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\CommissionData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Response containing list of affiliate commissions.
 *
 * Each entry exposes the full spec field set via {@see CommissionData}.
 *
 * @link https://digistore24.com/api/docs/paths/listCommissions.yaml
 */
final class ListCommissionsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Current page number
     */
    public int $pageNo = 1;

    /**
     * Number of items per page
     */
    public int $pageSize = 0;

    /**
     * Total number of items
     */
    public int $itemCount = 0;

    /**
     * Total number of pages
     */
    public int $pageCount = 0;

    /**
     * Commission items (spec key: `items`)
     *
     * @var array<int, CommissionData>
     */
    public array $items = [];

    /**
     * Check if there are more pages.
     */
    public function hasMorePages(): bool
    {
        return $this->pageNo < $this->pageCount;
    }

    /**
     * Get total commission amount across the returned items.
     */
    public function getTotalAmount(): float
    {
        return array_reduce(
            $this->items,
            static fn (float $sum, CommissionData $item): float => $sum + ($item->amount ?? 0.0),
            0.0,
        );
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $items = [];
        $itemsData = $innerData['items'] ?? [];
        if (is_array($itemsData)) {
            foreach ($itemsData as $item) {
                if (! is_array($item)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedItem */
                $validatedItem = $item;
                $items[] = CommissionData::fromArray($validatedItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->pageNo = TypeConverter::toInt($innerData['page_no'] ?? 1) ?? 1;
        $response->pageSize = TypeConverter::toInt($innerData['page_size'] ?? 0) ?? 0;
        $response->itemCount = TypeConverter::toInt($innerData['item_count'] ?? 0) ?? 0;
        $response->pageCount = TypeConverter::toInt($innerData['page_count'] ?? 0) ?? 0;
        $response->items = $items;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
