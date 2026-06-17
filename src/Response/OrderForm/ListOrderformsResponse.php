<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\OrderForm;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\OrderformListItemData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Order Forms Response
 *
 * Response containing the list of order forms. The spec returns a bare JSON
 * array; each item is exposed as a {@see OrderformListItemData}.
 *
 * @link https://digistore24.com/api/docs/paths/listOrderforms.yaml
 */
final class ListOrderformsResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The order forms as typed DTOs.
     *
     * @var array<int, OrderformListItemData>
     */
    public array $orderforms = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        // The spec returns a bare array; older payloads wrap the list under the
        // `orderforms` key. Support both shapes.
        $orderformsData = $innerData['orderforms'] ?? $innerData;
        if (! is_array($orderformsData)) {
            $orderformsData = [];
        }

        $orderforms = [];
        foreach ($orderformsData as $item) {
            if (! is_array($item)) {
                continue;
            }
            /** @var array<string, mixed> $validatedItem */
            $validatedItem = $item;
            $orderforms[] = OrderformListItemData::fromArray($validatedItem);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->orderforms = $orderforms;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
