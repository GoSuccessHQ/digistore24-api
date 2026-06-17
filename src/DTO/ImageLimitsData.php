<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Image Limits Data
 *
 * The `limits` object of a single image-type entry returned by getGlobalSettings.
 * Describes the size constraints for an image category. Response-only DTO: all
 * fields use get-only property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getGlobalSettings.yaml
 */
final class ImageLimitsData extends AbstractDataTransferObject
{
    /**
     * Maximum allowed file size in kilobytes
     */
    public ?int $maxFileSizeKb = null {
        get => $this->maxFileSizeKb;
    }

    /**
     * Minimum allowed image width in pixels
     */
    public ?int $minWidth = null {
        get => $this->minWidth;
    }

    /**
     * Maximum allowed image width in pixels
     */
    public ?int $maxWidth = null {
        get => $this->maxWidth;
    }

    /**
     * Minimum allowed image height in pixels
     */
    public ?int $minHeight = null {
        get => $this->minHeight;
    }

    /**
     * Maximum allowed image height in pixels
     */
    public ?int $maxHeight = null {
        get => $this->maxHeight;
    }
}
