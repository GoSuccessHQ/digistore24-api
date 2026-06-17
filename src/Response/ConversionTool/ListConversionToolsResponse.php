<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ConversionTool;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\ConversionToolData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Conversion Tools Response
 *
 * The API groups conversion tools by category (e.g. `smartupgrades`,
 * `socialproof_box`, `countdown`). The smart upgrades are exposed as a typed
 * {@see ConversionToolData} list; the complete payload (including any other
 * requested categories) is available via {@see $data}.
 *
 * @link https://digistore24.com/api/docs/paths/listConversionTools.yaml
 */
final class ListConversionToolsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Smart upgrade conversion tools (spec key: `smartupgrades`)
     *
     * @var array<int, ConversionToolData>
     */
    public array $smartupgrades = [];

    /**
     * The complete payload as returned by the API, grouped by conversion tool
     * category, so categories beyond smart upgrades remain accessible.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $smartupgrades = [];
        $smartupgradesData = $innerData['smartupgrades'] ?? [];
        if (is_array($smartupgradesData)) {
            foreach ($smartupgradesData as $item) {
                if (! is_array($item)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedItem */
                $validatedItem = $item;
                $smartupgrades[] = ConversionToolData::fromArray($validatedItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->smartupgrades = $smartupgrades;
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
