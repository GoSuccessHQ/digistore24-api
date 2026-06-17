<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Image Meta Data
 *
 * A single entry of the `image_metas` dictionary returned by getGlobalSettings.
 * Each entry describes one image category (e.g. "product") with its display
 * label, size constraints, and a readable description of those constraints.
 * Response-only DTO: all fields use get-only property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getGlobalSettings.yaml
 */
final class ImageMetaData extends AbstractDataTransferObject
{
    /**
     * Display name for the image category
     */
    public ?string $label = null {
        get => $this->label;
    }

    /**
     * Size constraints for the image category
     */
    public ?ImageLimitsData $limits = null {
        get => $this->limits;
    }

    /**
     * Readable description combining all constraints
     */
    public ?string $limitsMsg = null {
        get => $this->limitsMsg;
    }
}
