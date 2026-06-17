<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Country;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\CountryData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Countries Response
 *
 * Contains array of countries with localized names and VAT information.
 */
final class ListCountriesResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Array of countries
     *
     * @var array<int, CountryData>
     */
    public array $countries = [];

    /**
     * Total number of countries
     */
    public int $total = 0;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $countriesData = $innerData['countries'] ?? [];
        if (! is_array($countriesData)) {
            $countriesData = [];
        }

        /** @var array<int, CountryData> $countries */
        $countries = array_values(array_map(
            function (mixed $item): CountryData {
                if (! is_array($item)) {
                    return new CountryData();
                }

                /** @var array<string, mixed> $itemData */
                $itemData = $item;

                return CountryData::fromArray($itemData);
            },
            $countriesData,
        ));

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->countries = $countries;
        $response->total = TypeConverter::toInt($innerData['total'] ?? null) ?? 0;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
