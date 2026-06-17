<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Affiliate Toplist Item Data Transfer Object
 *
 * Represents a single affiliate ranking entry returned in data.top_list[] by
 * statsAffiliateToplist. Response-only: all properties expose get hooks.
 *
 * @link https://digistore24.com/api/docs/paths/statsAffiliateToplist.yaml
 */
final class AffiliateToplistItemData extends AbstractDataTransferObject
{
    /**
     * Unique affiliate identifier.
     */
    public ?int $affiliateId = null {
        get => $this->affiliateId;
    }

    /**
     * Affiliate display name.
     */
    public ?string $affiliateName = null {
        get => $this->affiliateName;
    }

    /**
     * Transaction currency code.
     */
    public ?string $currency = null {
        get => $this->currency;
    }

    /**
     * Gross revenue total.
     */
    public ?float $bruttoAmount = null {
        get => $this->bruttoAmount;
    }

    /**
     * Net revenue amount.
     */
    public ?float $nettoAmount = null {
        get => $this->nettoAmount;
    }

    /**
     * Total payments processed.
     */
    public ?float $paymentAmount = null {
        get => $this->paymentAmount;
    }

    /**
     * Refund transaction sum.
     */
    public ?float $refundAmount = null {
        get => $this->refundAmount;
    }

    /**
     * Chargeback dispute total.
     */
    public ?float $chargebackAmount = null {
        get => $this->chargebackAmount;
    }

    /**
     * Cancelled transaction sum.
     */
    public ?float $cancellationAmount = null {
        get => $this->cancellationAmount;
    }

    /**
     * Commission earned by the affiliate.
     */
    public ?float $affiliateAmount = null {
        get => $this->affiliateAmount;
    }

    /**
     * Amount retained by the merchant.
     */
    public ?float $merchantAmount = null {
        get => $this->merchantAmount;
    }

    /**
     * Refund percentage rate.
     */
    public ?float $refundQuota = null {
        get => $this->refundQuota;
    }

    /**
     * Chargeback percentage rate.
     */
    public ?float $chargebackQuota = null {
        get => $this->chargebackQuota;
    }

    /**
     * Cancellation percentage rate.
     */
    public ?float $cancellationQuota = null {
        get => $this->cancellationQuota;
    }
}
