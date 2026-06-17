<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Product Approval Status
 *
 * Approval status accepted by createProduct and updateProduct. Unlike
 * AffiliateApprovalStatus, these endpoints only allow "new" and "pending".
 */
enum ProductApprovalStatus: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case NEW = 'new';
    case PENDING = 'pending';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'New',
            self::PENDING => 'Pending',
        };
    }
}
