<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Product Group Response
 *
 * Response containing the ID of the newly created product group.
 *
 * @link https://digistore24.com/api/docs/paths/createProductGroup.yaml
 */
final class CreateProductGroupResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * ID of the created product group (spec key: `product_group_id`).
     */
    public ?int $productGroupId = null;

    /**
     * The complete response payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * The created product group ID as a string for backward compatibility.
     */
    public function getProductGroupId(): ?string
    {
        $value = $this->data['product_group_id'] ?? null;

        if (is_string($value)) {
            return $value;
        }

        return is_int($value) ? (string)$value : null;
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->productGroupId = TypeConverter::toInt($innerData['product_group_id'] ?? null);
        $response->data = $validatedData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
