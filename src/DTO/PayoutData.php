<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Payout Data Transfer Object
 *
 * Represents a single payout record as returned by listPayouts.
 *
 * @link https://digistore24.com/api/docs/paths/listPayouts.yaml
 */
final class PayoutData extends AbstractDataTransferObject
{
    /**
     * Payout record identifier
     */
    public ?int $id {
        get => $this->id ?? null;
    }

    /**
     * URL to the credit note PDF
     */
    public ?string $creditNoteUrl {
        get => $this->creditNoteUrl ?? null;
    }

    /**
     * URL to the commissions CSV file
     */
    public ?string $commissionListUrl {
        get => $this->commissionListUrl ?? null;
    }

    /**
     * Name of the reseller entity
     */
    public ?string $resellerName {
        get => $this->resellerName ?? null;
    }

    /**
     * Unique identifier for the reseller
     */
    public ?int $resellerId {
        get => $this->resellerId ?? null;
    }

    /**
     * Timestamp when the payout was created
     */
    public ?DateTimeImmutable $createdAt {
        get => $this->createdAt ?? null;
    }

    /**
     * Timestamp when the payout was processed
     */
    public ?DateTimeImmutable $processedAt {
        get => $this->processedAt ?? null;
    }

    /**
     * VAT rate percentage
     */
    public ?float $vatRate {
        get => $this->vatRate ?? null;
    }

    /**
     * VAT regulation classification
     */
    public ?string $vatRegulation {
        get => $this->vatRegulation ?? null;
    }

    /**
     * Three-letter currency code
     */
    public ?string $currency {
        get => $this->currency ?? null;
    }

    /**
     * Payment method (e.g. "paypal")
     */
    public ?string $payoutMethod {
        get => $this->payoutMethod ?? null;
    }

    /**
     * Total vendor earnings before VAT deduction
     */
    public ?float $vendorGrossAmount {
        get => $this->vendorGrossAmount ?? null;
    }

    /**
     * Vendor earnings after VAT
     */
    public ?float $vendorNetAmount {
        get => $this->vendorNetAmount ?? null;
    }

    /**
     * VAT charged on vendor earnings
     */
    public ?float $vendorVatAmount {
        get => $this->vendorVatAmount ?? null;
    }

    /**
     * Total affiliate earnings before VAT
     */
    public ?float $affiliateGrossAmount {
        get => $this->affiliateGrossAmount ?? null;
    }

    /**
     * Affiliate earnings after VAT
     */
    public ?float $affiliateNetAmount {
        get => $this->affiliateNetAmount ?? null;
    }

    /**
     * VAT on affiliate earnings
     */
    public ?float $affiliateVatAmount {
        get => $this->affiliateVatAmount ?? null;
    }

    /**
     * Processing fees
     */
    public ?float $feeAmount {
        get => $this->feeAmount ?? null;
    }

    /**
     * VAT on fees
     */
    public ?float $feeVatAmount {
        get => $this->feeVatAmount ?? null;
    }
}
