<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Payment Plan Discount Tier Data Transfer Object
 *
 * One quantity-based pricing tier used in the createPaymentplan /
 * updatePaymentplan `discount_unit_prices` array. Uses PHP 8.4 property hooks
 * for automatic validation.
 *
 * @link https://digistore24.com/api/docs/paths/createPaymentplan.yaml
 * @link https://digistore24.com/api/docs/paths/updatePaymentplan.yaml
 */
final class PaymentPlanDiscountTierData extends AbstractDataTransferObject
{
    /**
     * Minimum quantity threshold this tier applies from
     */
    public ?int $fromQuantity = null {
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('From quantity must be non-negative');
            }
            $this->fromQuantity = $value;
        }
    }

    /**
     * Unit price for the first payment
     */
    public ?float $unitPrice1st = null {
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('Unit price for first payment must be positive');
            }
            $this->unitPrice1st = $value;
        }
    }

    /**
     * Unit price for recurring (follow-up) payments
     */
    public ?float $unitPriceOth = null {
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('Unit price for recurring payments must be positive');
            }
            $this->unitPriceOth = $value;
        }
    }

    /**
     * Convert to array for API request.
     *
     * Emits the spec's exact snake_case keys (`from_quantity`, `unit_price_1st`,
     * `unit_price_oth`); the camelCase reflection default would otherwise produce
     * `unit_price1st` / `unit_price_oth`, so this is overridden explicitly.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];
        if ($this->fromQuantity !== null) {
            $data['from_quantity'] = $this->fromQuantity;
        }
        if ($this->unitPrice1st !== null) {
            $data['unit_price_1st'] = $this->unitPrice1st;
        }
        if ($this->unitPriceOth !== null) {
            $data['unit_price_oth'] = $this->unitPriceOth;
        }

        return $data;
    }
}
