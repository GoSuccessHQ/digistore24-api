<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Refund Policy Data
 *
 * The `refund_policy` object returned by getPurchase. Describes the refund
 * conditions applied to an order. Response-only DTO: all fields use get-only
 * hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getPurchase.yaml
 */
final class RefundPolicyData extends AbstractDataTransferObject
{
    /**
     * Purchase ID
     */
    public ?string $purchaseId = null {
        get => $this->purchaseId;
    }

    /**
     * Reason for the applied refund policy (business, consumer, common, vendor)
     */
    public ?string $reasonCode = null {
        get => $this->reasonCode;
    }

    /**
     * Number of days allowed for a refund
     */
    public ?int $refundDays = null {
        get => $this->refundDays;
    }

    /**
     * Whether reminders are allowed (response value is the Y/N enum, exposed as bool)
     */
    public ?bool $isReminderAllowed = null {
        get => $this->isReminderAllowed;
    }

    /**
     * Refund policy ID
     */
    public ?int $policyId = null {
        get => $this->policyId;
    }

    /**
     * Product type ID
     */
    public ?int $productTypeId = null {
        get => $this->productTypeId;
    }

    /**
     * Type of delivery (digital, shipping, service, event)
     */
    public ?string $deliveryType = null {
        get => $this->deliveryType;
    }

    /**
     * Text of the refund waiver checkbox
     */
    public ?string $checkboxText = null {
        get => $this->checkboxText;
    }
}
