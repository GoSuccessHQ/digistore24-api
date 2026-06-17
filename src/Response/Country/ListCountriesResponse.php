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
 * The API returns the countries set up in Digistore24 as a map of two-letter
 * ISO codes to localized country names. They are exposed here both as a typed
 * {@see CountryData} list and as the raw `code => name` map.
 *
 * @link https://digistore24.com/api/docs/paths/listCountries.yaml
 */
final class ListCountriesResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Countries as a typed list
     *
     * @var array<int, CountryData>
     */
    public array $countries = [];

    /**
     * Raw map of ISO country code to localized country name
     *
     * @var array<string, string>
     */
    public array $countryMap = [];

    /**
     * Total number of countries returned
     */
    public int $total = 0;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $countries = [];
        $countryMap = [];

        foreach ($innerData as $code => $value) {
            // Skip envelope/meta keys that may travel alongside the map.
            if (in_array($code, ['result', 'api_version', 'current_time', 'runtime_seconds'], true)) {
                continue;
            }

            // The live API delivers a flat `code => name` map, but tolerate a
            // list of objects ({code, name}) as well for forward compatibility.
            if (is_array($value)) {
                /** @var array<string, mixed> $itemData */
                $itemData = $value;
                $country = CountryData::fromArray($itemData);
                $countries[] = $country;
                $countryMap[$country->code] = $country->name;

                continue;
            }

            $codeString = (string)$code;
            $name = TypeConverter::toString($value) ?? '';
            $countryMap[$codeString] = $name;
            $countries[] = CountryData::fromArray(['code' => $codeString, 'name' => $name]);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->countries = $countries;
        $response->countryMap = $countryMap;
        $response->total = count($countries);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
