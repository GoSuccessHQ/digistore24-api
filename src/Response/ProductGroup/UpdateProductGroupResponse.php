<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Update Product Group Response
 *
 * Response object for the ProductGroup API endpoint.
 */
final class UpdateProductGroupResponse extends AbstractResponse
{
    public string $result = '';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
