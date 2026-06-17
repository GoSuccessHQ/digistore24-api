<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Country;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * @see https://digistore24.com/api/docs/paths/listCountries.yaml
 */
final class ListCountriesRequest extends AbstractRequest
{
    public function __construct()
    {
    }

    public function getEndpoint(): string
    {
        return '/listCountries';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
