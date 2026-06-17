<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Upgrade Status
 *
 * Whether the buy URL created by createBuyUrl can be used as an upgrade for the
 * supplied purchase (createBuyUrl response field `upgrade_status`).
 *
 * @link https://digistore24.com/api/docs/paths/createBuyUrl.yaml
 */
enum UpgradeStatus: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    /** No upgrade applies (no upgrade purchase requested) */
    case NONE = 'none';

    /** The upgrade is valid and can be processed */
    case OK = 'ok';

    /** The upgrade could not be applied */
    case ERROR = 'error';

    public function label(): string
    {
        return match ($this) {
            self::NONE => 'None',
            self::OK => 'OK',
            self::ERROR => 'Error',
        };
    }
}
