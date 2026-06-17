<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Buyer Readonly Keys
 *
 * Controls which prefilled buyer fields the customer may not change on the
 * order form when creating a buy URL (createBuyUrl `buyer.readonly_keys`).
 *
 * @link https://digistore24.com/api/docs/paths/createBuyUrl.yaml
 */
enum BuyerReadonlyKeys: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    /** No buyer fields are locked */
    case NONE = 'none';

    /** Only the email address is locked */
    case EMAIL = 'email';

    /** Email address and the buyer name are locked */
    case EMAIL_AND_NAME = 'email_and_name';

    /** All prefilled buyer fields are locked */
    case ALL = 'all';

    public function label(): string
    {
        return match ($this) {
            self::NONE => 'None',
            self::EMAIL => 'Email',
            self::EMAIL_AND_NAME => 'Email and Name',
            self::ALL => 'All',
        };
    }
}
