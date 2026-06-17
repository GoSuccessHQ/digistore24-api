<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\BuyUrl;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\BuyUrlData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Buy URLs Response
 *
 * Contains a list of buy URLs.
 */
final class ListBuyUrlsResponse extends AbstractResponse
{
    /**
     * List of buy URLs
     *
     * @var array<BuyUrlData>
     */
    public array $items = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $items = [];
        $itemsData = $data['items'] ?? [];

        if (is_array($itemsData)) {
            foreach ($itemsData as $itemData) {
                if (! is_array($itemData)) {
                    continue;
                }

                $buyUrlData = BuyUrlData::fromArray(data: [
                    'id' => TypeConverter::toInt($itemData['id'] ?? null) ?? 0,
                    'productId' => TypeConverter::toInt($itemData['product_id'] ?? null),
                    'url' => $itemData['url'] ?? '',
                    'createdAt' => TypeConverter::toDateTime($itemData['created_at'] ?? null),
                    'modifiedAt' => TypeConverter::toDateTime($itemData['modified_at'] ?? null),
                ]);

                $items[] = $buyUrlData;
            }
        }

        $response = new self();
        $response->items = $items;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
