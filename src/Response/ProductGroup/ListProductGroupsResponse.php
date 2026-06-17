<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\ProductGroupListItemData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Product Groups Response
 *
 * Response containing the list of product groups. The spec returns a bare JSON
 * array; each item is exposed as a {@see ProductGroupListItemData}.
 *
 * @link https://digistore24.com/api/docs/paths/listProductGroups.yaml
 */
final class ListProductGroupsResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The product groups as typed DTOs.
     *
     * @var array<int, ProductGroupListItemData>
     */
    public array $productGroups = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        // The spec returns a bare array; older payloads wrap the list under the
        // `product_groups` key. Support both shapes.
        $groupsData = $innerData['product_groups'] ?? $innerData;
        if (! is_array($groupsData)) {
            $groupsData = [];
        }

        $groups = [];
        foreach ($groupsData as $item) {
            if (! is_array($item)) {
                continue;
            }
            /** @var array<string, mixed> $validatedItem */
            $validatedItem = $item;
            $groups[] = ProductGroupListItemData::fromArray($validatedItem);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->productGroups = $groups;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
