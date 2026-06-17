<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Buyer;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Buyers Response
 *
 * Response for a paginated list of buyers. Mirrors the spec's `data` object:
 * the `items` array of buyer objects plus the pagination fields page_no,
 * page_size, item_count and page_count.
 *
 * @link https://digistore24.com/api/docs/paths/listBuyers.yaml
 */
final class ListBuyersResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Array of buyers (spec key: `items`)
     *
     * @var array<int, BuyerData>
     */
    public array $items = [];

    /**
     * Current page number
     */
    public int $pageNo = 0;

    /**
     * Number of items per page
     */
    public int $pageSize = 0;

    /**
     * Total number of buyers across all pages
     */
    public int $itemCount = 0;

    /**
     * Total number of pages
     */
    public int $pageCount = 0;

    /**
     * The complete inner payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $itemsData = $innerData['items'] ?? [];
        if (! is_array($itemsData)) {
            $itemsData = [];
        }

        /** @var array<int, BuyerData> $items */
        $items = array_values(array_map(
            static function (mixed $item): BuyerData {
                if (! is_array($item)) {
                    return new BuyerData();
                }

                /** @var array<string, mixed> $itemData */
                $itemData = $item;

                return BuyerData::fromArray($itemData);
            },
            $itemsData,
        ));

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->items = $items;
        $response->pageNo = TypeConverter::toInt($innerData['page_no'] ?? null) ?? 0;
        $response->pageSize = TypeConverter::toInt($innerData['page_size'] ?? null) ?? 0;
        $response->itemCount = TypeConverter::toInt($innerData['item_count'] ?? null) ?? 0;
        $response->pageCount = TypeConverter::toInt($innerData['page_count'] ?? null) ?? 0;
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
