<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Country;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\CurrencyData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * @see https://digistore24.com/api/docs/paths/listCurrencies.yaml
 */
final class ListCurrenciesResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Array of currencies
     *
     * @var array<int, CurrencyData>
     */
    public array $currencies = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $currenciesData = $innerData['currencies'] ?? $innerData;
        if (! is_array($currenciesData)) {
            $currenciesData = [];
        }

        /** @var array<int, CurrencyData> $currencies */
        $currencies = array_values(array_map(
            function (mixed $item): CurrencyData {
                if (! is_array($item)) {
                    return new CurrencyData();
                }

                /** @var array<string, mixed> $itemData */
                $itemData = $item;

                return CurrencyData::fromArray($itemData);
            },
            $currenciesData,
        ));

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->currencies = $currencies;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
