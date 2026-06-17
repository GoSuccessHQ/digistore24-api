<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * UTM Params Data
 *
 * The `utm_params` object returned within getPurchaseTracking. Holds the UTM
 * tracking parameters of an order. Response-only DTO: all fields use get-only
 * property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getPurchaseTracking.yaml
 */
final class UtmParamsData extends AbstractDataTransferObject
{
    /**
     * UTM source parameter
     */
    public ?string $utmSource = null {
        get => $this->utmSource;
    }

    /**
     * UTM medium parameter
     */
    public ?string $utmMedium = null {
        get => $this->utmMedium;
    }

    /**
     * UTM campaign parameter
     */
    public ?string $utmCampaign = null {
        get => $this->utmCampaign;
    }

    /**
     * UTM term parameter
     */
    public ?string $utmTerm = null {
        get => $this->utmTerm;
    }

    /**
     * UTM content parameter
     */
    public ?string $utmContent = null {
        get => $this->utmContent;
    }
}
