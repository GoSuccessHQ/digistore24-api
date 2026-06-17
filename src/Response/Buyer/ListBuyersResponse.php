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
 * Response for paginated list of buyers.
 * Contains pagination information and array of BuyerData objects.
 */
final class ListBuyersResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Array of buyers
     *
     * @var array<int, BuyerData>
     */
    public array $buyers = [];

    /**
     * Total number of buyers
     */
    public int $total = 0;

    /**
     * Result limit
     */
    public int $limit = 100;

    /**
     * Result offset
     */
    public int $offset = 0;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $buyersData = $innerData['buyers'] ?? [];
        if (! is_array($buyersData)) {
            $buyersData = [];
        }

        /** @var array<int, BuyerData> $buyers */
        $buyers = array_values(array_map(
            function (mixed $item): BuyerData {
                if (! is_array($item)) {
                    return new BuyerData();
                }

                /** @var array<string, mixed> $itemData */
                $itemData = $item;

                return BuyerData::fromArray($itemData);
            },
            $buyersData,
        ));

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->buyers = $buyers;
        $response->total = TypeConverter::toInt($innerData['total'] ?? null) ?? 0;
        $response->limit = TypeConverter::toInt($innerData['limit'] ?? null) ?? 100;
        $response->offset = TypeConverter::toInt($innerData['offset'] ?? null) ?? 0;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
