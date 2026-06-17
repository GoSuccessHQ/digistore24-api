<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\TypeConverter;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Billing Addon Data
 *
 * A single entry of the `addons` request array for createBillingOnDemand. Unlike
 * {@see AddonData} (used by createAddonChangePurchase), this addon supports the
 * extended createBillingOnDemand fields. Only the fields the spec defines are
 * emitted by {@see self::toArray()}.
 *
 * @link https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml
 */
final class BillingAddonData extends AbstractDataTransferObject
{
    /**
     * Product ID of the addon
     */
    public string $productId = '';

    /**
     * First payment amount for subscriptions/installments
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
     * Follow-up payment amounts
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
     * Purchase amount for single payments
     */
    public ?float $singleAmount = null {
        set {
            if ($value !== null && $value < 0) {
                throw new \InvalidArgumentException('Single amount must be positive');
            }
            $this->singleAmount = $value;
        }
    }

    /**
     * Quantity of the addon (minimum: 1)
     */
    public int $quantity = 1 {
        set {
            if ($value < 1) {
                throw new \InvalidArgumentException('Quantity must be at least 1');
            }
            $this->quantity = $value;
        }
    }

    /**
     * Three-character currency code
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
     * Can the buyer change the quantity after purchase
     */
    public bool $isQuantityEditableAfterPurchase = false;

    /**
     * Two-letter country code for the addon
     */
    public ?string $productCountry = null {
        set {
            if ($value !== null && ! Validator::isCountryCode($value)) {
                throw new \InvalidArgumentException('Product country must be a 2-character country code');
            }
            $this->productCountry = $value !== null ? strtoupper($value) : null;
        }
    }

    /**
     * Convert to array for API request.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'product_id' => $this->productId,
            'quantity' => $this->quantity,
            'is_quantity_editable_after_purchase' => TypeConverter::fromBool($this->isQuantityEditableAfterPurchase),
        ];

        if ($this->firstAmount !== null) {
            $data['first_amount'] = $this->firstAmount;
        }
        if ($this->otherAmounts !== null) {
            $data['other_amounts'] = $this->otherAmounts;
        }
        if ($this->singleAmount !== null) {
            $data['single_amount'] = $this->singleAmount;
        }
        if ($this->currency !== null) {
            $data['currency'] = $this->currency;
        }
        if ($this->productCountry !== null) {
            $data['product_country'] = $this->productCountry;
        }

        return $data;
    }
}
