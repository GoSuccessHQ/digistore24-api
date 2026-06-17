<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Affiliate Priority
 *
 * Controls how an affiliate passed to createBuyUrl is prioritized against an
 * affiliate the buyer may already be assigned to (createBuyUrl
 * `tracking.affiliate_priority`).
 *
 * @link https://digistore24.com/api/docs/paths/createBuyUrl.yaml
 */
enum AffiliatePriority: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    /** Prefer the affiliate already linked to the buyer's email */
    case EMAIL = 'email';

    /** Always use the affiliate as set in the request */
    case AS_SET = 'as_set';

    public function label(): string
    {
        return match ($this) {
            self::EMAIL => 'Email',
            self::AS_SET => 'As Set',
        };
    }
}
