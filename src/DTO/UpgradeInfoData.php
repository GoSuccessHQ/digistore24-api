<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Upgrade Info Data
 *
 * The `upgrade_info` object returned by createUpgradePurchase. Describes the
 * upgrade transaction details. Response-only DTO: all fields use get-only
 * property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/createUpgradePurchase.yaml
 */
final class UpgradeInfoData extends AbstractDataTransferObject
{
    /**
     * Type of upgrade performed
     */
    public ?string $upgradeType = null {
        get => $this->upgradeType;
    }

    /**
     * Remaining upgrade amount
     */
    public ?float $upgradeAmountLeft = null {
        get => $this->upgradeAmountLeft;
    }

    /**
     * Total upgrade amount
     */
    public ?float $upgradeAmountTotal = null {
        get => $this->upgradeAmountTotal;
    }

    /**
     * ID of the upgraded purchase
     */
    public ?string $upgradedPurchaseId = null {
        get => $this->upgradedPurchaseId;
    }
}
