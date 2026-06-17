<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Product;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Delete Product Response
 *
 * Response object for the Product API endpoint.
 */
final class DeleteProductResponse extends AbstractResponse
{
    public string $result = '';

    public bool $success = true;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->success = true;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
