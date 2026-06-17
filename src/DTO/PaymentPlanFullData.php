<?php

declare (strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\TypeConverter;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Payment Plan Full Data Transfer Object
 *
 * Complete data structure for payment plan creation and updates. Carries every
 * field the createPaymentplan / updatePaymentplan `data` object accepts.
 * Uses PHP 8.4 property hooks for automatic validation.
 *
 * @link https://digistore24.com/api/docs/paths/createPaymentplan.yaml
 * @link https://digistore24.com/api/docs/paths/updatePaymentplan.yaml
 */
final class PaymentPlanFullData extends AbstractDataTransferObject
{
    /**
     * Amount of first payment
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
     * Interval between purchase and second payment
     * Examples: 4_day, 1_week, 1_month, 3_month, 6_month, 12_month
     */
    public ?string $firstBillingInterval = null;

    /**
     * Three-character currency code
     */
    public ?string $currency = null {
        set {
            if ($value !== null && ! Validator::isCurrencyCode($value)) {
                throw new \InvalidArgumentException('Currency must be 3-character code');
            }
            $this->currency = $value !== null ? strtoupper($value) : null;
        }
    }

    /**
     * Amount for follow-up payments
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
     * Interval for follow-up payments
     * Examples: 1_week, 1_month, 3_month, 6_month, 12_month
     */
    public ?string $otherBillingIntervals = null;

    /**
     * Number of installments
     * 0 = subscription (indefinite)
     * 1 = single payment
     * >= 2 = installment plan
     */
    public ?int $numberOfInstallments = null {
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('Number of installments must be non-negative');
            }
            $this->numberOfInstallments = $value;
        }
    }

    /**
     * Test/trial period interval (e.g., 7_day)
     */
    public ?string $testInterval = null;

    /**
     * Fixed start date for the payment plan
     * Format: YYYY-MM-DD
     */
    public ?string $startPayplanAt = null {
        set {
            if ($value !== null && ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                throw new \InvalidArgumentException('Start payplan at must be in YYYY-MM-DD format');
            }
            $this->startPayplanAt = $value;
        }
    }

    /**
     * Whether the payment plan is active
     */
    public ?bool $isActive = null;

    /**
     * Display position of the payment plan
     */
    public ?int $position = null {
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('Position must be positive');
            }
            $this->position = $value;
        }
    }

    /**
     * Cancellation policy (minimum term)
     * Format: {minimum_term}m_{notice_period}m
     * Examples: 6m_0, 6m_6m, 12m_3m, 24m_12m
     */
    public ?string $cancelPolicy = null {
        set {
            $allowedPolicies = ['6m_0', '6m_6m', '6m_12m', '12m_0', '12m_3m', '12m_6m', '12m_12m', '24m_0', '24m_6m', '24m_12m'];
            if ($value !== null && ! in_array($value, $allowedPolicies, true)) {
                throw new \InvalidArgumentException("Invalid cancel policy: {$value}. Allowed: " . implode(', ', $allowedPolicies));
            }
            $this->cancelPolicy = $value;
        }
    }

    /**
     * Sale type designation.
     * Options: all, new, upgrade, or a comma-separated combination.
     */
    public ?string $isForSale = null;

    /**
     * Whether buyers may switch to/from this payment plan (Y/N)
     */
    public ?bool $isSwitchingAllowed = null;

    /**
     * Whether the buyer may terminate the installments.
     * Allowed: Y, N, N_subscription
     */
    public ?string $canBuyerTerminateInstallments = null {
        set {
            if ($value !== null && ! in_array($value, ['Y', 'N', 'N_subscription'], true)) {
                throw new \InvalidArgumentException(
                    "Invalid can_buyer_terminate_installments: {$value}. Allowed: Y, N, N_subscription",
                );
            }
            $this->canBuyerTerminateInstallments = $value;
        }
    }

    /**
     * Whether quantity discounts are enabled (Y/N)
     */
    public ?bool $isDiscountEnabled = null;

    /**
     * Quantity-based pricing tiers.
     *
     * @var array<int, PaymentPlanDiscountTierData>
     */
    public array $discountUnitPrices = [];

    /**
     * Convert to array for API request.
     *
     * The booleans map to the Digistore24 'Y'/'N' format; only non-null fields
     * are emitted so partial updates do not overwrite untouched values.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];
        if ($this->firstAmount !== null) {
            $data['first_amount'] = $this->firstAmount;
        }
        if ($this->firstBillingInterval !== null) {
            $data['first_billing_interval'] = $this->firstBillingInterval;
        }
        if ($this->currency !== null) {
            $data['currency'] = $this->currency;
        }
        if ($this->otherAmounts !== null) {
            $data['other_amounts'] = $this->otherAmounts;
        }
        if ($this->otherBillingIntervals !== null) {
            $data['other_billing_intervals'] = $this->otherBillingIntervals;
        }
        if ($this->numberOfInstallments !== null) {
            $data['number_of_installments'] = $this->numberOfInstallments;
        }
        if ($this->testInterval !== null) {
            $data['test_interval'] = $this->testInterval;
        }
        if ($this->startPayplanAt !== null) {
            $data['start_payplan_at'] = $this->startPayplanAt;
        }
        if ($this->isActive !== null) {
            $data['is_active'] = TypeConverter::fromBool($this->isActive);
        }
        if ($this->position !== null) {
            $data['position'] = $this->position;
        }
        if ($this->cancelPolicy !== null) {
            $data['cancel_policy'] = $this->cancelPolicy;
        }
        if ($this->isForSale !== null) {
            $data['is_for_sale'] = $this->isForSale;
        }
        if ($this->isSwitchingAllowed !== null) {
            $data['is_switching_allowed'] = TypeConverter::fromBool($this->isSwitchingAllowed);
        }
        if ($this->canBuyerTerminateInstallments !== null) {
            $data['can_buyer_terminate_installments'] = $this->canBuyerTerminateInstallments;
        }
        if ($this->isDiscountEnabled !== null) {
            $data['is_discount_enabled'] = TypeConverter::fromBool($this->isDiscountEnabled);
        }
        if ($this->discountUnitPrices !== []) {
            $data['discount_unit_prices'] = array_map(
                static fn (PaymentPlanDiscountTierData $tier): array => $tier->toArray(),
                array_values($this->discountUnitPrices),
            );
        }

        return $data;
    }
}
