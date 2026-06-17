<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\System;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Response containing global Digistore24 settings.
 */
final class GetGlobalSettingsResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Available product types
     *
     * @var array<array{id: int, name: string}>
     */
    public array $productTypes = [];

    /**
     * Available countries
     *
     * @var array<array{code: string, name: string}>
     */
    public array $countries = [];

    /**
     * Available currencies
     *
     * @var array<array{code: string, symbol: string, name: string}>
     */
    public array $currencies = [];

    /**
     * Available languages
     *
     * @var array<array{code: string, name: string}>
     */
    public array $languages = [];

    /**
     * Available payment methods
     *
     * @var array<string>
     */
    public array $paymentMethods = [];

    /**
     * VAT rates by country code
     *
     * @var array<string, float>
     */
    public array $vatRates = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);

        // Product types
        $productTypes = [];
        if (isset($innerData['product_types']) && is_array($innerData['product_types'])) {
            foreach ($innerData['product_types'] as $type) {
                if (is_array($type) && isset($type['id'], $type['name']) && is_int($type['id']) && is_string($type['name'])) {
                    $productTypes[] = [
                        'id' => $type['id'],
                        'name' => $type['name'],
                    ];
                }
            }
        }
        $response->productTypes = $productTypes;

        // Countries
        $countries = [];
        if (isset($innerData['countries']) && is_array($innerData['countries'])) {
            foreach ($innerData['countries'] as $country) {
                if (is_array($country) && isset($country['code'], $country['name']) && is_string($country['code']) && is_string($country['name'])) {
                    $countries[] = [
                        'code' => $country['code'],
                        'name' => $country['name'],
                    ];
                }
            }
        }
        $response->countries = $countries;

        // Currencies
        $currencies = [];
        if (isset($innerData['currencies']) && is_array($innerData['currencies'])) {
            foreach ($innerData['currencies'] as $currency) {
                if (is_array($currency) && isset($currency['code'], $currency['symbol'], $currency['name']) && is_string($currency['code']) && is_string($currency['symbol']) && is_string($currency['name'])) {
                    $currencies[] = [
                        'code' => $currency['code'],
                        'symbol' => $currency['symbol'],
                        'name' => $currency['name'],
                    ];
                }
            }
        }
        $response->currencies = $currencies;

        // Languages
        $languages = [];
        if (isset($innerData['languages']) && is_array($innerData['languages'])) {
            foreach ($innerData['languages'] as $language) {
                if (is_array($language) && isset($language['code'], $language['name']) && is_string($language['code']) && is_string($language['name'])) {
                    $languages[] = [
                        'code' => $language['code'],
                        'name' => $language['name'],
                    ];
                }
            }
        }
        $response->languages = $languages;

        // Payment methods
        $paymentMethods = [];
        if (isset($innerData['payment_methods']) && is_array($innerData['payment_methods'])) {
            foreach ($innerData['payment_methods'] as $method) {
                if (is_string($method)) {
                    $paymentMethods[] = $method;
                }
            }
        }
        $response->paymentMethods = $paymentMethods;

        // VAT rates
        $vatRates = [];
        if (isset($innerData['vat_rates']) && is_array($innerData['vat_rates'])) {
            foreach ($innerData['vat_rates'] as $countryCode => $rate) {
                if (is_string($countryCode) && (is_float($rate) || is_int($rate))) {
                    $vatRates[$countryCode] = (float)$rate;
                }
            }
        }
        $response->vatRates = $vatRates;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
