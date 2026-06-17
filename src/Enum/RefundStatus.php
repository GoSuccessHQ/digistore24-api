<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Refund Status
 *
 * Status of a refund processed via refundTransaction.
 *
 * @link https://digistore24.com/api/docs/paths/refundTransaction.yaml
 */
enum RefundStatus: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case COMPLETED = 'completed';
    case REFUSED = 'refused';
    case PENDING = 'pending';
    case ERROR = 'error';

    public function label(): string
    {
        return match ($this) {
            self::COMPLETED => 'Completed',
            self::REFUSED => 'Refused',
            self::PENDING => 'Pending',
            self::ERROR => 'Error',
        };
    }
}
