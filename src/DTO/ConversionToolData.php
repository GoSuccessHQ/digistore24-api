<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Conversion Tool Data Transfer Object
 *
 * Represents a single conversion tool entry (e.g. a smart upgrade) as returned
 * by listConversionTools.
 *
 * @link https://digistore24.com/api/docs/paths/listConversionTools.yaml
 */
final class ConversionToolData extends AbstractDataTransferObject
{
    /**
     * Conversion tool ID
     */
    public ?int $id {
        get => $this->id ?? null;
    }

    /**
     * Conversion tool name
     */
    public ?string $name {
        get => $this->name ?? null;
    }

    /**
     * Authentication key for the conversion tool
     */
    public ?string $authkey {
        get => $this->authkey ?? null;
    }

    /**
     * Creation timestamp
     */
    public ?DateTimeImmutable $createdAt {
        get => $this->createdAt ?? null;
    }

    /**
     * Whether custom CSS is used (spec key: `is_custom_css_used`, Y/N)
     */
    public ?bool $isCustomCssUsed {
        get => $this->isCustomCssUsed ?? null;
    }

    /**
     * Custom CSS, if any
     */
    public ?string $customCss {
        get => $this->customCss ?? null;
    }

    /**
     * Target product ID the upgrade leads to (spec key: `upgrade_to_product_id`)
     */
    public ?int $upgradeToProductId {
        get => $this->upgradeToProductId ?? null;
    }

    /**
     * Comma-separated list of product IDs the tool applies to
     */
    public ?string $productIds {
        get => $this->productIds ?? null;
    }
}
