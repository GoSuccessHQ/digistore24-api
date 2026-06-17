<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Referring Affiliate Action
 *
 * Describes what setReferringAffiliate did with the referral relationship.
 *
 * @link https://digistore24.com/api/docs/paths/setReferringAffiliate.yaml
 */
enum ReferringAffiliateAction: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case READ = 'read';
    case CREATE = 'create';
    case UPDATE = 'update';
    case NONE = 'none';

    public function label(): string
    {
        return match ($this) {
            self::READ => 'Read',
            self::CREATE => 'Create',
            self::UPDATE => 'Update',
            self::NONE => 'None',
        };
    }
}
