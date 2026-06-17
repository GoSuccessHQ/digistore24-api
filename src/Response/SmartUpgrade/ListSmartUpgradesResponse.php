<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\SmartUpgrade;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\SmartUpgradeData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Smart Upgrades Response
 *
 * Response object for the listSmartUpgrades API endpoint. The inner `data`
 * object holds a `smartupgrades` array; every entry is exposed as a typed
 * {@see SmartUpgradeData} DTO.
 *
 * @link https://digistore24.com/api/docs/paths/listSmartUpgrades.yaml
 */
final class ListSmartUpgradesResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Smart upgrade configurations (spec key: `smartupgrades`)
     *
     * @var array<int, SmartUpgradeData>
     */
    public array $smartupgrades = [];

    /**
     * The complete inner payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $smartupgradesData = $innerData['smartupgrades'] ?? [];
        $smartupgrades = [];

        if (is_array($smartupgradesData)) {
            foreach ($smartupgradesData as $item) {
                if (! is_array($item)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedItem */
                $validatedItem = $item;
                $smartupgrades[] = SmartUpgradeData::fromArray(data: $validatedItem);
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
