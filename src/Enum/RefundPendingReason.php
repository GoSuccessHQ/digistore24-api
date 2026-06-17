<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Refund Pending Reason
 *
 * Reason why a refund is still pending after refundTransaction.
 *
 * @link https://digistore24.com/api/docs/paths/refundTransaction.yaml
 */
enum RefundPendingReason: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case DEFAULT_DELAY = 'default_delay';
    case PROOF_MISSING = 'proof_missing';
    case PROOF_APROVAL = 'proof_aproval';
    case BLOCKED = 'blocked';

    public function label(): string
    {
        return match ($this) {
            self::DEFAULT_DELAY => 'Default Delay',
            self::PROOF_MISSING => 'Proof Missing',
            self::PROOF_APROVAL => 'Proof Approval',
            self::BLOCKED => 'Blocked',
        };
    }
}
