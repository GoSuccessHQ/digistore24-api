<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Country Data Transfer Object
 *
 * Represents a single country as returned by listCountries, which delivers a
 * map of two-letter ISO codes to localized country names.
 *
 * @link https://digistore24.com/api/docs/paths/listCountries.yaml
 */
final class CountryData extends AbstractDataTransferObject
{
    /**
     * Country code (ISO 3166-1 alpha-2)
     */
    public string $code {
        get => $this->code ?? '';
    }

    /**
     * Country name (localized)
     */
    public string $name {
        get => $this->name ?? '';
    }
}
