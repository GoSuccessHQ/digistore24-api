<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Upgrade Type
 *
 * Defines how an upgrade/downgrade is handled in createBillingOnDemand and
 * createUpgradePurchase payment plans.
 *
 * @link https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml
 */
enum UpgradeType: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case UPGRADE = 'upgrade';
    case DOWNGRADE = 'downgrade';

    public function label(): string
    {
        return match ($this) {
            self::UPGRADE => 'Upgrade',
            self::DOWNGRADE => 'Downgrade',
        };
    }
}
