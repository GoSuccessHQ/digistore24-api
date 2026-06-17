<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Smart Upgrade Data
 *
 * A single smart-upgrade configuration as returned by listSmartUpgrades and
 * getSmartupgrade. A smart upgrade lets buyers of one or more source products
 * upgrade to a target product via a generated widget. Response-only DTO: all
 * fields use get-only property hooks.
 *
 * The `is_custom_css_used` flag is delivered by the API as the Digistore24
 * "Y"/"N" string and is converted to a bool automatically by the reflection
 * based fromArray() in AbstractDataTransferObject.
 *
 * @link https://digistore24.com/api/docs/paths/listSmartUpgrades.yaml
 * @link https://digistore24.com/api/docs/paths/getSmartupgrade.yaml
 */
final class SmartUpgradeData extends AbstractDataTransferObject
{
    /**
     * Smart upgrade ID
     */
    public ?int $id = null {
        get => $this->id;
    }

    /**
     * Smart upgrade name
     */
    public ?string $name = null {
        get => $this->name;
    }

    /**
     * Authentication key used to embed the smart-upgrade widget
     */
    public ?string $authkey = null {
        get => $this->authkey;
    }

    /**
     * Creation timestamp
     */
    public ?DateTimeImmutable $createdAt = null {
        get => $this->createdAt;
    }

    /**
     * Whether a custom CSS is used for the widget
     *
     * Delivered by the API as "Y"/"N" and exposed as a bool.
     */
    public ?bool $isCustomCssUsed = null {
        get => $this->isCustomCssUsed;
    }

    /**
     * Custom CSS applied to the widget (nullable)
     */
    public ?string $customCss = null {
        get => $this->customCss;
    }

    /**
     * Target product ID the buyer is upgraded to
     */
    public ?int $upgradeToProductId = null {
        get => $this->upgradeToProductId;
    }

    /**
     * Comma-separated list of source product IDs the smart upgrade applies to
     */
    public ?string $productIds = null {
        get => $this->productIds;
    }
}
