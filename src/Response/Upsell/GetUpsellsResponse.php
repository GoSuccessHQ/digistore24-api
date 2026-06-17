<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Upsell;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Upsells Response
 *
 * Response containing the upsell configuration for a product. Mirrors the spec's
 * data object (product_id, upsells tree, product_options).
 *
 * @link https://digistore24.com/api/docs/paths/getUpsells.yaml
 */
final class GetUpsellsResponse extends AbstractResponse
{
    public string $result = '';

    /** ID of the initial product the upsell tree belongs to */
    public ?int $productId = null;

    /**
     * Upsell tree mapping position codes to product IDs.
     *
     * Keys use the characters y/n (1-5 chars, beginning with y), e.g. `y`, `yn`,
     * `yy`, `yny`, where the value is the product ID offered at that position.
     *
     * @var array<string, mixed>
     */
    public array $upsells = [];

    /**
     * Additional product options keyed by product ID.
     *
     * @var array<string, mixed>
     */
    public array $productOptions = [];

    /**
     * The complete data payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $upsells = $innerData['upsells'] ?? [];
        if (! is_array($upsells)) {
            $upsells = [];
        }
        /** @var array<string, mixed> $validatedUpsells */
        $validatedUpsells = $upsells;

        $productOptions = $innerData['product_options'] ?? [];
        if (! is_array($productOptions)) {
            $productOptions = [];
        }
        /** @var array<string, mixed> $validatedProductOptions */
        $validatedProductOptions = $productOptions;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->productId = TypeConverter::toInt($innerData['product_id'] ?? null);
        $response->upsells = $validatedUpsells;
        $response->productOptions = $validatedProductOptions;
        $response->data = $innerData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
