<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Billing Settings Data
 *
 * The `settings` request object for createBillingOnDemand. Holds additional
 * order-form settings. Only the fields the spec defines are emitted by
 * {@see self::toArray()}.
 *
 * @link https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml
 */
final class BillingSettingsData extends AbstractDataTransferObject
{
    /**
     * Voucher to apply at payment
     */
    public ?string $voucherCode = null;

    /**
     * Quantity of the main product (minimum: 1)
     */
    public ?int $quantity = null {
        set {
            if ($value !== null && $value < 1) {
                throw new \InvalidArgumentException('Quantity must be at least 1');
            }
            $this->quantity = $value;
        }
    }

    /**
     * Two-letter country code for the product
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
        $data = [];

        if ($this->voucherCode !== null) {
            $data['voucher_code'] = $this->voucherCode;
        }
        if ($this->quantity !== null) {
            $data['quantity'] = $this->quantity;
        }
        if ($this->productCountry !== null) {
            $data['product_country'] = $this->productCountry;
        }

        return $data;
    }
}
