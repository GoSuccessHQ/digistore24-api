<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Upgrade New Purchase Data
 *
 * The `new_purchase` object returned by createUpgradePurchase. Describes the
 * purchase created by the upgrade. Response-only DTO: all fields use get-only
 * property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/createUpgradePurchase.yaml
 */
final class UpgradeNewPurchaseData extends AbstractDataTransferObject
{
    /**
     * Purchase ID
     */
    public ?string $id = null {
        get => $this->id;
    }

    /**
     * Current billing status
     */
    public ?string $billingStatus = null {
        get => $this->billingStatus;
    }

    /**
     * Amount already paid
     */
    public ?float $paidAmount = null {
        get => $this->paidAmount;
    }

    /**
     * Date of next payment
     */
    public ?string $nextPaymentAt = null {
        get => $this->nextPaymentAt;
    }

    /**
     * Amount of next payment
     */
    public ?float $nextAmount = null {
        get => $this->nextAmount;
    }

    /**
     * Currency code
     */
    public ?string $currency = null {
        get => $this->currency;
    }
}
