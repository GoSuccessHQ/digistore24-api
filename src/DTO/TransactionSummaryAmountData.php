<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Transaction Summary Amount Data
 *
 * One per-currency bucket of the `summary.amounts` object returned by
 * listTransactions. The `amounts` object is keyed by currency code, and each
 * value is one of these aggregates. Response-only DTO: all fields use get-only
 * property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/listTransactions.yaml
 */
final class TransactionSummaryAmountData extends AbstractDataTransferObject
{
    /**
     * Number of transactions in this currency bucket.
     */
    public ?int $count = null {
        get => $this->count;
    }

    /**
     * Total transaction amount (gross).
     */
    public ?float $totalAmount = null {
        get => $this->totalAmount;
    }

    /**
     * Total VAT amount.
     */
    public ?float $vatAmount = null {
        get => $this->vatAmount;
    }

    /**
     * Total earned amount.
     */
    public ?float $earnedAmount = null {
        get => $this->earnedAmount;
    }
}
