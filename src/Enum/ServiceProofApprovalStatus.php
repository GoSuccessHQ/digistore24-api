<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Service Proof Approval Status
 *
 * Approval status of a service proof request, used as a list filter and as the
 * value reported on a request.
 *
 * @link https://digistore24.com/api/docs/paths/listServiceProofRequests.yaml
 */
enum ServiceProofApprovalStatus: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case NEW = 'new';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'New',
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        };
    }
}
