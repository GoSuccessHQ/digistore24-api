<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Enum;

use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Trait\StringBackedEnumTrait;

/**
 * Service Proof Request Status
 *
 * Status of a service proof request. Used both as a list filter and as the
 * value reported on a request. Note: updateServiceProofRequest only accepts
 * `proof_provided` or `exec_refund` (see ServiceProofRequestUpdateData).
 *
 * @link https://digistore24.com/api/docs/paths/listServiceProofRequests.yaml
 */
enum ServiceProofRequestStatus: string implements StringBackedEnum
{
    use StringBackedEnumTrait;

    case PENDING = 'pending';
    case PROOF_PROVIDED = 'proof_provided';
    case EXEC_REFUND = 'exec_refund';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROOF_PROVIDED => 'Proof Provided',
            self::EXEC_REFUND => 'Execute Refund',
        };
    }
}
