<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\System;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\ImageMetaData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Global Settings Response
 *
 * Response containing global Digistore24 system settings. The inner `data`
 * object has exactly two top-level keys:
 *
 * - `image_metas`: a dictionary keyed by image-type identifier (e.g. "product")
 *   whose values describe the size constraints for that image category.
 * - `types`: a dictionary keyed by enumeration name (e.g. "first_billing_interval")
 *   whose values map an option id to its localized display string
 *   (e.g. {"4_day": "4 Tage"}).
 *
 * @link https://digistore24.com/api/docs/paths/getGlobalSettings.yaml
 */
final class GetGlobalSettingsResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Image constraints keyed by image-type identifier (e.g. "product").
     *
     * @var array<string, ImageMetaData>
     */
    public array $imageMetas = [];

    /**
     * Enumerations keyed by enumeration name. Each value maps an option id to its
     * localized display string, e.g. ["first_billing_interval" => ["4_day" => "4 Tage"]].
     *
     * @var array<string, array<string, string>>
     */
    public array $types = [];

    /**
     * The complete inner payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->imageMetas = self::buildImageMetas($innerData['image_metas'] ?? null);
        $response->types = self::buildTypes($innerData['types'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * Build the `image_metas` dictionary. Keys are dynamic image-type identifiers,
     * so the map is built with an explicit loop rather than reflection.
     *
     * @param mixed $imageMetas
     * @return array<string, ImageMetaData>
     */
    private static function buildImageMetas(mixed $imageMetas): array
    {
        if (! is_array($imageMetas)) {
            return [];
        }

        $result = [];
        foreach ($imageMetas as $type => $meta) {
            if (! is_string($type) || ! is_array($meta)) {
                continue;
            }

            $result[$type] = ImageMetaData::fromArray(self::toStringKeyedArray($meta));
        }

        return $result;
    }

    /**
     * Build the `types` dictionary. Both the outer keys (enumeration names) and the
     * inner keys (option ids) are dynamic, so the nested map is built with explicit
     * loops and validated to keep the typed array shape.
     *
     * @param mixed $types
     * @return array<string, array<string, string>>
     */
    private static function buildTypes(mixed $types): array
    {
        if (! is_array($types)) {
            return [];
        }

        $result = [];
        foreach ($types as $enumName => $options) {
            if (! is_string($enumName) || ! is_array($options)) {
                continue;
            }

            $mappedOptions = [];
            foreach ($options as $optionId => $label) {
                if (is_string($optionId) && is_string($label)) {
                    $mappedOptions[$optionId] = $label;
                }
            }

            $result[$enumName] = $mappedOptions;
        }

        return $result;
    }

    /**
     * @param array<mixed, mixed> $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(array $value): array
    {
        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
