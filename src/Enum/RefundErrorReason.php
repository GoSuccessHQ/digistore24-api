<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Refund Error Reason
 *
 * Reason why a refund failed after refundTransaction.
 *
 * @link https://digistore24.com/api/docs/paths/refundTransaction.yaml
 */
enum RefundErrorReason: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case REFUND_COMPLETED = 'refund_completed';
    case REFUND_PENDING = 'refund_pending';
    case UNKNOWN = 'unknown';

    public function label(): string
    {
        return match ($this) {
            self::REFUND_COMPLETED => 'Refund Completed',
            self::REFUND_PENDING => 'Refund Pending',
            self::UNKNOWN => 'Unknown',
        };
    }
}
