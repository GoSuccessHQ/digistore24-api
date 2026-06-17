<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Daily Amount Data Transfer Object
 *
 * Represents a single daily revenue record returned in data.amount_list[] by
 * statsDailyAmounts. Response-only: all properties expose get hooks.
 *
 * @link https://digistore24.com/api/docs/paths/statsDailyAmounts.yaml
 */
final class DailyAmountData extends AbstractDataTransferObject
{
    /**
     * Calendar date of the sales record (format: YYYY-MM-DD).
     */
    public ?string $day = null {
        get => $this->day;
    }

    /**
     * Monetary unit (currency code).
     */
    public ?string $currency = null {
        get => $this->currency;
    }

    /**
     * Vendor commission value.
     */
    public ?float $vendorShareAmount = null {
        get => $this->vendorShareAmount;
    }

    /**
     * Vendor gross sales.
     */
    public ?float $vendorBruttoAmount = null {
        get => $this->vendorBruttoAmount;
    }

    /**
     * Vendor net sales.
     */
    public ?float $vendorNettoAmount = null {
        get => $this->vendorNettoAmount;
    }

    /**
     * Affiliate commission value.
     */
    public ?float $affiliateShareAmount = null {
        get => $this->affiliateShareAmount;
    }

    /**
     * Affiliate gross sales.
     */
    public ?float $affiliateBruttoAmount = null {
        get => $this->affiliateBruttoAmount;
    }

    /**
     * Affiliate net sales.
     */
    public ?float $affiliateNettoAmount = null {
        get => $this->affiliateNettoAmount;
    }

    /**
     * Other party commission value.
     */
    public ?float $otherShareAmount = null {
        get => $this->otherShareAmount;
    }

    /**
     * Other party gross sales.
     */
    public ?float $otherBruttoAmount = null {
        get => $this->otherBruttoAmount;
    }

    /**
     * Other party net sales.
     */
    public ?float $otherNettoAmount = null {
        get => $this->otherNettoAmount;
    }

    /**
     * Combined commission value.
     */
    public ?float $totalShareAmount = null {
        get => $this->totalShareAmount;
    }

    /**
     * Combined gross sales.
     */
    public ?float $totalBruttoAmount = null {
        get => $this->totalBruttoAmount;
    }

    /**
     * Combined net sales.
     */
    public ?float $totalNettoAmount = null {
        get => $this->totalNettoAmount;
    }
}
