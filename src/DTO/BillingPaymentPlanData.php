<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Enum\UpgradeType;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Billing Payment Plan Data
 *
 * The `payment_plan` request object for createBillingOnDemand. Describes the
 * purchase price / payment plan of the created order. Only the fields the spec
 * defines are emitted by {@see self::toArray()}.
 *
 * @link https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml
 */
final class BillingPaymentPlanData extends AbstractDataTransferObject
{
    /**
     * The purchase price or first payment amount
     */
    public ?float $firstAmount = null {
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('First amount must be positive');
            }
            $this->firstAmount = $value;
        }
    }

    /**
     * Amount of follow-up payments for subscriptions/installments
     */
    public ?float $otherAmounts = null {
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('Other amounts must be positive');
            }
            $this->otherAmounts = $value;
        }
    }

    /**
     * Three-character currency code (e.g. EUR or USD)
     */
    public ?string $currency = null {
        set {
            if ($value !== null && ! Validator::isCurrencyCode($value)) {
                throw new \InvalidArgumentException('Currency must be 3-character code (e.g., USD, EUR)');
            }
            $this->currency = $value !== null ? strtoupper($value) : null;
        }
    }

    /**
     * Number of payments including the first (minimum: 1)
     */
    public ?int $numberOfInstallments = null {
        set {
            if ($value !== null && $value < 1) {
                throw new \InvalidArgumentException('Number of installments must be at least 1');
            }
            $this->numberOfInstallments = $value;
        }
    }

    /**
     * Time interval between purchase and second installment (e.g. "1_month")
     */
    public ?string $firstBillingInterval = null;

    /**
     * Time interval for second and further payments
     */
    public ?string $otherBillingIntervals = null;

    /**
     * Test interval before payment starts (e.g. "1_month")
     */
    public ?string $testInterval = null;

    /**
     * ID of the payment method used as a template
     */
    public ?string $template = null;

    /**
     * Type of upgrade handling
     */
    public ?UpgradeType $upgradeType = null;

    /**
     * Convert to array for API request.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->firstAmount !== null) {
            $data['first_amount'] = $this->firstAmount;
        }
        if ($this->otherAmounts !== null) {
            $data['other_amounts'] = $this->otherAmounts;
        }
        if ($this->currency !== null) {
            $data['currency'] = $this->currency;
        }
        if ($this->numberOfInstallments !== null) {
            $data['number_of_installments'] = $this->numberOfInstallments;
        }
        if ($this->firstBillingInterval !== null) {
            $data['first_billing_interval'] = $this->firstBillingInterval;
        }
        if ($this->otherBillingIntervals !== null) {
            $data['other_billing_intervals'] = $this->otherBillingIntervals;
        }
        if ($this->testInterval !== null) {
            $data['test_interval'] = $this->testInterval;
        }
        if ($this->template !== null) {
            $data['template'] = $this->template;
        }
        if ($this->upgradeType !== null) {
            $data['upgrade_type'] = $this->upgradeType->value;
        }

        return $data;
    }
}
