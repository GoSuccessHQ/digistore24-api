<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Purchase Item Data
 *
 * A single entry of the `items` array returned by getPurchase. Represents one
 * product line of an order. Response-only DTO: all fields use get-only hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getPurchase.yaml
 */
final class PurchaseItemData extends AbstractDataTransferObject
{
    /**
     * Product name
     */
    public ?string $productName = null {
        get => $this->productName;
    }

    /**
     * Product ID
     */
    public ?int $productId = null {
        get => $this->productId;
    }

    /**
     * Quantity purchased
     */
    public ?int $quantity = null {
        get => $this->quantity;
    }

    /**
     * Product variant key
     */
    public ?string $variantKey = null {
        get => $this->variantKey;
    }

    /**
     * Product variant name
     */
    public ?string $variantName = null {
        get => $this->variantName;
    }

    /**
     * Item number within the order
     */
    public ?int $no = null {
        get => $this->no;
    }

    /**
     * Total number of items
     */
    public ?int $count = null {
        get => $this->count;
    }

    /**
     * Purchase item ID
     */
    public ?int $id = null {
        get => $this->id;
    }
}
