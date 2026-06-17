<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Affiliation Status
 *
 * Status of an affiliation as returned by validateAffiliate.
 *
 * @link https://digistore24.com/api/docs/paths/validateAffiliate.yaml
 */
enum AffiliationStatus: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case APPROVED = 'approved';
    case NO_AFFILIATION = 'no_affiliation';
    case WAIT_FOR_APPROVAL = 'wait_for_approval';
    case NO_VALID_PRODUCTS = 'no_valid_products';

    public function label(): string
    {
        return match ($this) {
            self::APPROVED => 'Approved',
            self::NO_AFFILIATION => 'No affiliation',
            self::WAIT_FOR_APPROVAL => 'Waiting for approval',
            self::NO_VALID_PRODUCTS => 'No valid products',
        };
    }
}
