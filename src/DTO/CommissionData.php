<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Commission Data Transfer Object
 *
 * Represents a single affiliate commission entry as returned by listCommissions.
 *
 * @link https://digistore24.com/api/docs/paths/listCommissions.yaml
 */
final class CommissionData extends AbstractDataTransferObject
{
    /**
     * Commission identifier
     */
    public ?int $id {
        get => $this->id ?? null;
    }

    /**
     * Creation timestamp
     */
    public ?DateTimeImmutable $createdAt {
        get => $this->createdAt ?? null;
    }

    /**
     * Commission amount
     */
    public ?float $amount {
        get => $this->amount ?? null;
    }

    /**
     * Three-letter currency code
     */
    public ?string $currency {
        get => $this->currency ?? null;
    }

    /**
     * Reason / description of the commission
     */
    public ?string $reason {
        get => $this->reason ?? null;
    }

    /**
     * Scheduled payout date (spec key: `schedule_payout_at`, format: YYYY-MM-DD)
     */
    public ?string $schedulePayoutAt {
        get => $this->schedulePayoutAt ?? null;
    }

    /**
     * Related transaction ID
     */
    public ?int $transactionId {
        get => $this->transactionId ?? null;
    }

    /**
     * Digistore24 order ID the commission belongs to
     */
    public ?string $purchaseId {
        get => $this->purchaseId ?? null;
    }
}
