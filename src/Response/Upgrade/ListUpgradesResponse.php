<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\UpgradeItemData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Upgrades Response
 *
 * Response for the listUpgrades endpoint. The payload exposes all configured
 * upgrade paths under `upgrades`, each represented as an {@see UpgradeItemData}.
 *
 * @link https://digistore24.com/api/docs/paths/listUpgrades.yaml
 */
final class ListUpgradesResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The configured upgrade paths as typed DTOs.
     *
     * @var array<int, UpgradeItemData>
     */
    public array $upgrades = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $upgradesData = $innerData['upgrades'] ?? [];
        if (! is_array($upgradesData)) {
            $upgradesData = [];
        }

        $upgrades = [];
        foreach ($upgradesData as $upgrade) {
            if (! is_array($upgrade)) {
                continue;
            }
            /** @var array<string, mixed> $validatedUpgrade */
            $validatedUpgrade = $upgrade;
            $upgrades[] = UpgradeItemData::fromArray($validatedUpgrade);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->upgrades = $upgrades;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
