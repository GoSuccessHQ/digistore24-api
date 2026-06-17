<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Rebilling Status Change Type
 *
 * Type of a rebilling status change as returned by listRebillingStatusChanges.
 *
 * @link https://digistore24.com/api/docs/paths/listRebillingStatusChanges.yaml
 */
enum RebillingStatusChangeType: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case REBILL_CANCELLED = 'rebill_cancelled';
    case LAST_PAID_DAY = 'last_paid_day';
    case REBILL_RESUMED = 'rebill_resumed';

    public function label(): string
    {
        return match ($this) {
            self::REBILL_CANCELLED => 'Rebill Cancelled',
            self::LAST_PAID_DAY => 'Last Paid Day',
            self::REBILL_RESUMED => 'Rebill Resumed',
        };
    }
}
