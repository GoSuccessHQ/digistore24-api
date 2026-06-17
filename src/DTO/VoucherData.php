<?php

declare (strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\TypeConverter;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Voucher Data Transfer Object
 *
 * Data structure for voucher creation, updates and responses.
 * Uses PHP 8.4 property hooks for automatic validation.
 *
 * @link https://digistore24.com/api/docs/paths/createVoucher.yaml
 * @link https://digistore24.com/api/docs/paths/updateVoucher.yaml
 */
final class VoucherData extends AbstractDataTransferObject
{
    /**
     * Voucher ID (from responses)
     */
    public ?int $id = null {
        get => $this->id;
    }

    /**
     * The voucher code
     */
    public string $code = '' {
        get => $this->code;
        set {
            if (strlen($value) === 0) {
                throw new \InvalidArgumentException('Voucher code cannot be empty');
            }
            if (! Validator::isLength($value, null, 255)) {
                throw new \InvalidArgumentException('Voucher code must not exceed 255 characters');
            }
            $this->code = $value;
        }
    }

    /**
     * Comma-separated list of product IDs this voucher applies to
     * Default: "all"
     */
    public string $productIds = 'all' {
        get => $this->productIds;
    }

    /**
     * Point in time from when the code becomes valid
     * Format: YYYY-MM-DD HH:MM:SS (e.g., 2017-12-31 12:00:00)
     */
    public ?string $validFrom = null {
        get => $this->validFrom;
        set {
            if ($value !== null && ! preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $value)) {
                throw new \InvalidArgumentException('Valid from must be in YYYY-MM-DD HH:MM:SS format');
            }
            $this->validFrom = $value;
        }
    }

    /**
     * Point in time when the code becomes invalid (alias for expiresAt)
     * Format: YYYY-MM-DD HH:MM:SS
     */
    public ?string $validUntil = null {
        get => $this->validUntil;
    }

    /**
     * Point in time when the code becomes invalid
     * Format: YYYY-MM-DD HH:MM:SS
     */
    public ?string $expiresAt = null {
        get => $this->expiresAt;
        set {
            if ($value !== null && ! preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $value)) {
                throw new \InvalidArgumentException('Expires at must be in YYYY-MM-DD HH:MM:SS format');
            }
            $this->expiresAt = $value;
        }
    }

    /**
     * Discount percentage on first payment (subscriptions/installments) or single payment
     */
    public ?float $firstRate = null {
        get => $this->firstRate;
        set {
            if ($value !== null && ($value < 0 || $value > 100)) {
                throw new \InvalidArgumentException('First rate must be between 0 and 100');
            }
            $this->firstRate = $value;
        }
    }

    /**
     * Discount percentage on follow-up payments (subscriptions/installments)
     */
    public ?float $otherRates = null {
        get => $this->otherRates;
        set {
            if ($value !== null && ($value < 0 || $value > 100)) {
                throw new \InvalidArgumentException('Other rates must be between 0 and 100');
            }
            $this->otherRates = $value;
        }
    }

    /**
     * Fixed discount amount on first/single payment
     */
    public ?float $firstAmount = null {
        get => $this->firstAmount;
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('First amount must be positive');
            }
            $this->firstAmount = $value;
        }
    }

    /**
     * Fixed discount amount on follow-up payments
     */
    public ?float $otherAmounts = null {
        get => $this->otherAmounts;
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('Other amounts must be positive');
            }
            $this->otherAmounts = $value;
        }
    }

    /**
     * Currency code for the fixed discount amounts
     */
    public ?string $currency = null {
        get => $this->currency;
        set {
            if ($value !== null && ! Validator::isCurrencyCode($value)) {
                throw new \InvalidArgumentException('Currency must be 3-character code (e.g., USD, EUR)');
            }
            $this->currency = $value !== null ? strtoupper($value) : null;
        }
    }

    /**
     * Whether the number of uses is limited
     */
    public bool $isCountLimited = false {
        get => $this->isCountLimited;
    }

    /**
     * Number of remaining uses if isCountLimited is true
     */
    public int $countLeft = 1 {
        get => $this->countLeft;
        set {
            if ($value < 0) {
                throw new \InvalidArgumentException('Count left must be positive');
            }
            $this->countLeft = $value;
        }
    }

    /**
     * How the code is used for upgrades
     *
     * - valid: voucher fully usable
     * - other_only: only discount on follow-up installments
     * - not_valid: voucher not usable
     */
    public string $upgradePolicy = 'valid' {
        get => $this->upgradePolicy;
        set {
            if (! in_array($value, ['valid', 'other_only', 'not_valid'], true)) {
                throw new \InvalidArgumentException("Invalid upgrade policy: {$value}. Allowed: valid, other_only, not_valid");
            }
            $this->upgradePolicy = $value;
        }
    }

    /**
     * Whether using this voucher discards an active early-bird discount (response-only).
     *
     * Returned by listVouchers as the string enum "Y"/"N" and exposed here as a bool.
     */
    public ?bool $isDiscardingEarlyBird = null {
        get => $this->isDiscardingEarlyBird;
    }

    /**
     * Convert to array for createVoucher/updateVoucher requests.
     *
     * Only the request fields the spec defines are emitted. The response-only
     * fields (`id`, the `validUntil` alias, and `is_discarding_early_bird`) are
     * intentionally excluded so they never leak into a request payload.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'code' => $this->code,
            'product_ids' => $this->productIds,
            'is_count_limited' => TypeConverter::fromBool($this->isCountLimited),
            'count_left' => $this->countLeft,
            'upgrade_policy' => $this->upgradePolicy,
        ];

        if ($this->validFrom !== null) {
            $data['valid_from'] = $this->validFrom;
        }
        if ($this->expiresAt !== null) {
            $data['expires_at'] = $this->expiresAt;
        }
        if ($this->firstRate !== null) {
            $data['first_rate'] = $this->firstRate;
        }
        if ($this->otherRates !== null) {
            $data['other_rates'] = $this->otherRates;
        }
        if ($this->firstAmount !== null) {
            $data['first_amount'] = $this->firstAmount;
        }
        if ($this->otherAmounts !== null) {
            $data['other_amounts'] = $this->otherAmounts;
        }
        if ($this->currency !== null) {
            $data['currency'] = $this->currency;
        }

        return $data;
    }
}
