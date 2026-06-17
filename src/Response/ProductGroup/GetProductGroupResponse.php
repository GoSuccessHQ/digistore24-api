<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Product Group Response
 *
 * Response object for the ProductGroup API endpoint.
 */
final class GetProductGroupResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $productGroup = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $productGroupData = $innerData['product_group'] ?? [];
        if (! is_array($productGroupData)) {
            $productGroupData = [];
        }
        /** @var array<string, mixed> $validatedProductGroup */
        $validatedProductGroup = $productGroupData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->productGroup = $validatedProductGroup;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
