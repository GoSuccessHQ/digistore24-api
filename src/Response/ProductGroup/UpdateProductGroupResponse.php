<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Update Product Group Response
 *
 * Response indicating whether the product group was modified.
 *
 * @link https://digistore24.com/api/docs/paths/updateProductGroup.yaml
 */
final class UpdateProductGroupResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Whether the product group was modified (spec: data.is_modified, Y/N).
     */
    public ?bool $isModified = null;

    /**
     * The complete response payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->isModified = TypeConverter::toBool($innerData['is_modified'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
