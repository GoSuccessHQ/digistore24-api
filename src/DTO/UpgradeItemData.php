<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Upgrade Item Data Transfer Object
 *
 * Represents a single upgrade as returned by getUpgrade (data.item) and
 * listUpgrades (data.upgrades[]). Response-only: all properties expose get hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getUpgrade.yaml
 * @link https://digistore24.com/api/docs/paths/listUpgrades.yaml
 */
final class UpgradeItemData extends AbstractDataTransferObject
{
    /**
     * The unique identifier of the upgrade.
     */
    public ?int $id = null {
        get => $this->id;
    }

    /**
     * The name of the upgrade.
     */
    public ?string $name = null {
        get => $this->name;
    }

    /**
     * The buy URL for the upgrade. Contains a placeholder for the order ID.
     */
    public ?string $upgradeUrl = null {
        get => $this->upgradeUrl;
    }

    /**
     * The product ID being sold as the upgrade.
     */
    public ?int $toProductId = null {
        get => $this->toProductId;
    }

    /**
     * The name of the product being sold as the upgrade (getUpgrade only).
     */
    public ?string $toProductName = null {
        get => $this->toProductName;
    }

    /**
     * Whether the upgrade is active and purchasable ("Y"/"N").
     */
    public ?bool $isActive = null {
        get => $this->isActive;
    }

    /**
     * The authentication key used in the upgrade URL.
     */
    public ?string $authkey = null {
        get => $this->authkey;
    }

    /**
     * Product ID offered if the upgrade is not possible.
     */
    public ?int $fallbackProductId = null {
        get => $this->fallbackProductId;
    }

    /**
     * Which buyer data fields are protected (none, email, email_and_name, all).
     */
    public ?string $buyerReadonlyKeys = null {
        get => $this->buyerReadonlyKeys;
    }

    /**
     * Map of source product ID to upgrade behavior (upgrade, downgrade, special_offer).
     *
     * @var array<string, string>
     */
    public array $upgradeTypes = [] {
        get => $this->upgradeTypes;
    }
}
