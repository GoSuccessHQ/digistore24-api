<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\OrderForm;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Orderform Metas Response
 *
 * Response containing the configuration metadata available for order forms:
 * the available placeholders, the selectable option lists, and additional form
 * metadata. The complete payload is also exposed via {@see self::$data}.
 *
 * @link https://digistore24.com/api/docs/paths/getOrderformMetas.yaml
 */
final class GetOrderformMetasResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Available placeholders (e.g. `images` and `other` maps).
     *
     * @var array<string, mixed>
     */
    public array $placeholders = [];

    /**
     * Selectable option lists keyed by setting (e.g. `background_style`,
     * `step_count`, `tab_style`, `image`).
     *
     * @var array<string, mixed>
     */
    public array $options = [];

    /**
     * Additional form metadata.
     *
     * @var array<string, mixed>
     */
    public array $formMetas = [];

    /**
     * The complete metas payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $responseData = self::extractInnerData($data);
        /** @var array<string, mixed> $validatedData */
        $validatedData = $responseData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->placeholders = self::toStringKeyedArray($validatedData['placeholders'] ?? null);
        $response->options = self::toStringKeyedArray($validatedData['options'] ?? null);
        $response->formMetas = self::toStringKeyedArray($validatedData['form_metas'] ?? null);
        $response->data = $validatedData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @param mixed $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
