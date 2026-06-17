<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Purchase Transaction Data
 *
 * A single entry of the `transaction_list` returned by getPurchase. Represents
 * one payment or refund booked against an order. Response-only DTO: all fields
 * use get-only property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getPurchase.yaml
 */
final class PurchaseTransactionData extends AbstractDataTransferObject
{
    /**
     * Transaction ID
     */
    public ?int $id = null {
        get => $this->id;
    }

    /**
     * Transaction amount
     */
    public ?float $amount = null {
        get => $this->amount;
    }

    /**
     * Currency code
     */
    public ?string $currency = null {
        get => $this->currency;
    }

    /**
     * Associated purchase ID
     */
    public ?string $purchaseId = null {
        get => $this->purchaseId;
    }

    /**
     * Payment method code
     */
    public ?string $payMethod = null {
        get => $this->payMethod;
    }

    /**
     * Payment method in readable form
     */
    public ?string $payMethodMsg = null {
        get => $this->payMethodMsg;
    }

    /**
     * Transaction timestamp
     */
    public ?DateTimeImmutable $createdAt = null {
        get => $this->createdAt;
    }

    /**
     * Transaction type (payment or refund)
     */
    public ?string $type = null {
        get => $this->type;
    }

    /**
     * Transaction type in readable form
     */
    public ?string $typeMsg = null {
        get => $this->typeMsg;
    }

    /**
     * URL to download the invoice
     */
    public ?string $invoiceUrl = null {
        get => $this->invoiceUrl;
    }
}
