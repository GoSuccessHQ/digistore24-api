<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Product Groups Response
 *
 * Response object for the ProductGroup API endpoint.
 */
final class ListProductGroupsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $productGroups = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $productGroupsData = $innerData['product_groups'] ?? [];
        if (! is_array($productGroupsData)) {
            $productGroupsData = [];
        }
        /** @var array<string, mixed> $validatedProductGroups */
        $validatedProductGroups = $productGroupsData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->productGroups = $validatedProductGroups;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
