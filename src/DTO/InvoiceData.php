<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Invoice Data Transfer Object
 *
 * Represents a single invoice as returned by listInvoices.
 *
 * @link https://digistore24.com/api/docs/paths/listInvoices.yaml
 */
final class InvoiceData extends AbstractDataTransferObject
{
    /**
     * URL to the invoice PDF
     */
    public ?string $invoiceUrl {
        get => $this->invoiceUrl ?? null;
    }

    /**
     * Human-readable label for the invoice
     */
    public ?string $invoiceLabel {
        get => $this->invoiceLabel ?? null;
    }

    /**
     * Invoice identifier
     */
    public ?string $invoiceId {
        get => $this->invoiceId ?? null;
    }

    /**
     * Invoice date (format: YYYY-MM-DD)
     */
    public ?string $invoiceDate {
        get => $this->invoiceDate ?? null;
    }

    /**
     * Payment method code
     */
    public ?string $payMethod {
        get => $this->payMethod ?? null;
    }

    /**
     * Payment method in readable form
     */
    public ?string $payMethodMsg {
        get => $this->payMethodMsg ?? null;
    }

    /**
     * Digistore24 order ID this invoice belongs to
     */
    public ?string $purchaseId {
        get => $this->purchaseId ?? null;
    }

    /**
     * Invoice type (e.g. "invoice", "credit_note")
     */
    public ?string $type {
        get => $this->type ?? null;
    }

    /**
     * Invoice amount (returned as a formatted string by the API)
     */
    public ?string $amount {
        get => $this->amount ?? null;
    }

    /**
     * Three-letter currency code
     */
    public ?string $currency {
        get => $this->currency ?? null;
    }
}
