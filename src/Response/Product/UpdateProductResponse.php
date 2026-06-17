<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Product;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Update Product Response
 *
 * Response object for the Product API endpoint.
 */
final class UpdateProductResponse extends AbstractResponse
{
    public string $result = '';

    public string $modified = 'N';

    public function wasModified(): bool
    {
        return $this->modified === 'Y';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $modified = $innerData['modified'] ?? 'N';

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->modified = is_string($modified) ? $modified : 'N';
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
