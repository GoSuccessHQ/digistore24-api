<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Purchase Of Email Data
 *
 * A single entry returned by listPurchasesOfEmail. Represents one purchase
 * belonging to a buyer's email address. Response-only DTO: all fields use
 * get-only property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/listPurchasesOfEmail.yaml
 */
final class PurchaseOfEmailData extends AbstractDataTransferObject
{
    /**
     * Purchase ID
     */
    public ?string $id = null {
        get => $this->id;
    }

    /**
     * Purchase creation timestamp
     */
    public ?DateTimeImmutable $createdAt = null {
        get => $this->createdAt;
    }

    /**
     * Purchase amount
     */
    public ?float $amount = null {
        get => $this->amount;
    }

    /**
     * Purchase currency
     */
    public ?string $currency = null {
        get => $this->currency;
    }

    /**
     * Purchase status
     */
    public ?string $status = null {
        get => $this->status;
    }
}
