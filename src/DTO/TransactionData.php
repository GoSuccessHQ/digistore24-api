<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Transaction Data
 *
 * A single entry of the `transaction_list` returned by listTransactions.
 * Represents one payment, refund, chargeback or refund request. Response-only
 * DTO: all fields use get-only property hooks.
 *
 * The nested `buyer` object is exposed as a typed {@see TransactionBuyerData}
 * and is hydrated automatically by the reflection-based hydrator in
 * {@see AbstractDataTransferObject::fromArray()}.
 *
 * @link https://digistore24.com/api/docs/paths/listTransactions.yaml
 */
final class TransactionData extends AbstractDataTransferObject
{
    /**
     * Transaction ID.
     */
    public ?int $id = null {
        get => $this->id;
    }

    /**
     * Associated purchase ID.
     */
    public ?string $purchaseId = null {
        get => $this->purchaseId;
    }

    /**
     * Transaction amount.
     */
    public ?float $amount = null {
        get => $this->amount;
    }

    /**
     * Currency code.
     */
    public ?string $currency = null {
        get => $this->currency;
    }

    /**
     * Transaction type (e.g. payment, refund, chargeback, refund_request).
     */
    public ?string $transactionType = null {
        get => $this->transactionType;
    }

    /**
     * Transaction type in readable form.
     */
    public ?string $transactionTypeMsg = null {
        get => $this->transactionTypeMsg;
    }

    /**
     * Transaction timestamp.
     */
    public ?DateTimeImmutable $createdAt = null {
        get => $this->createdAt;
    }

    /**
     * Buyer identity attached to the transaction.
     */
    public ?TransactionBuyerData $buyer = null {
        get => $this->buyer;
    }
}
