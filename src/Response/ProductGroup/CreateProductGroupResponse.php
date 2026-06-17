<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create Product Group Response
 *
 * Response object for the ProductGroup API endpoint.
 */
final class CreateProductGroupResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function getProductGroupId(): ?string
    {
        $value = $this->data['product_group_id'] ?? null;

        return is_string($value) ? $value : null;
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $validatedData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
