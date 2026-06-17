<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Period Amount Data Transfer Object
 *
 * Represents one period bucket of revenue figures returned by statsSales inside
 * data.amounts (keyed by currency, each an array of these period objects).
 * Response-only: all properties expose get hooks.
 *
 * @link https://digistore24.com/api/docs/paths/statsSales.yaml
 */
final class PeriodAmountData extends AbstractDataTransferObject
{
    /**
     * Period start date (format: YYYY-MM-DD).
     */
    public ?string $from = null {
        get => $this->from;
    }

    /**
     * Period end date (format: YYYY-MM-DD).
     */
    public ?string $to = null {
        get => $this->to;
    }

    /**
     * Vendor payout amount.
     */
    public ?float $vendorShareAmount = null {
        get => $this->vendorShareAmount;
    }

    /**
     * Vendor gross amount.
     */
    public ?float $vendorBruttoAmount = null {
        get => $this->vendorBruttoAmount;
    }

    /**
     * Vendor net amount.
     */
    public ?float $vendorNettoAmount = null {
        get => $this->vendorNettoAmount;
    }

    /**
     * Affiliate payout amount.
     */
    public ?float $affiliateShareAmount = null {
        get => $this->affiliateShareAmount;
    }

    /**
     * Affiliate gross amount.
     */
    public ?float $affiliateBruttoAmount = null {
        get => $this->affiliateBruttoAmount;
    }

    /**
     * Affiliate net amount.
     */
    public ?float $affiliateNettoAmount = null {
        get => $this->affiliateNettoAmount;
    }

    /**
     * Other roles payout amount.
     */
    public ?float $otherShareAmount = null {
        get => $this->otherShareAmount;
    }

    /**
     * Other roles gross amount.
     */
    public ?float $otherBruttoAmount = null {
        get => $this->otherBruttoAmount;
    }

    /**
     * Other roles net amount.
     */
    public ?float $otherNettoAmount = null {
        get => $this->otherNettoAmount;
    }

    /**
     * Combined payout total.
     */
    public ?float $totalShareAmount = null {
        get => $this->totalShareAmount;
    }

    /**
     * Combined gross total.
     */
    public ?float $totalBruttoAmount = null {
        get => $this->totalBruttoAmount;
    }

    /**
     * Combined net total.
     */
    public ?float $totalNettoAmount = null {
        get => $this->totalNettoAmount;
    }
}
