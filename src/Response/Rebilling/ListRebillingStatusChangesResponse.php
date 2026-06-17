<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\RebillingStatusChangeData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Rebilling Status Changes Response
 *
 * Response for listRebillingStatusChanges. The status changes are returned under
 * `items` (typed {@see RebillingStatusChangeData}) together with the query range
 * and pagination metadata.
 *
 * @link https://digistore24.com/api/docs/paths/listRebillingStatusChanges.yaml
 */
final class ListRebillingStatusChangesResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The rebilling status changes as typed DTOs.
     *
     * @var array<int, RebillingStatusChangeData>
     */
    public array $items = [];

    /**
     * Query start timestamp.
     */
    public ?string $from = null;

    /**
     * Query end timestamp.
     */
    public ?string $to = null;

    /**
     * Number of entries per page in the response.
     */
    public ?int $pageSize = null;

    /**
     * Current page number.
     */
    public ?int $pageNo = null;

    /**
     * Total number of pages available.
     */
    public ?int $pageCount = null;

    /**
     * Total count of matching items.
     */
    public ?int $itemCount = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        // Spec key is `items`; fall back to the legacy `status_changes` shape.
        $itemsData = $innerData['items'] ?? $innerData['status_changes'] ?? [];
        if (! is_array($itemsData)) {
            $itemsData = [];
        }

        $items = [];
        foreach ($itemsData as $item) {
            if (! is_array($item)) {
                continue;
            }
            /** @var array<string, mixed> $validatedItem */
            $validatedItem = $item;
            $items[] = RebillingStatusChangeData::fromArray($validatedItem);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->items = $items;
        $response->from = TypeConverter::toString($innerData['from'] ?? null);
        $response->to = TypeConverter::toString($innerData['to'] ?? null);
        $response->pageSize = TypeConverter::toInt($innerData['page_size'] ?? null);
        $response->pageNo = TypeConverter::toInt($innerData['page_no'] ?? null);
        $response->pageCount = TypeConverter::toInt($innerData['page_count'] ?? null);
        $response->itemCount = TypeConverter::toInt($innerData['item_count'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
