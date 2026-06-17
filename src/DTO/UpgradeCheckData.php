<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Upgrade Check Data Transfer Object
 *
 * Represents the data.check object returned by getUpgrade when order IDs are
 * supplied. Response-only: all properties expose get hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getUpgrade.yaml
 */
final class UpgradeCheckData extends AbstractDataTransferObject
{
    /**
     * Whether the upgrade is possible for the supplied order(s) ("Y"/"N").
     */
    public ?bool $isUpgradePossible = null {
        get => $this->isUpgradePossible;
    }

    /**
     * Whether a one-click payment is possible for the upgrade ("Y"/"N").
     */
    public ?bool $isOneClickPaymentPossible = null {
        get => $this->isOneClickPaymentPossible;
    }

    /**
     * The possible upgrade type (upgrade or downgrade).
     */
    public ?string $possibleUpgradeType = null {
        get => $this->possibleUpgradeType;
    }
}
