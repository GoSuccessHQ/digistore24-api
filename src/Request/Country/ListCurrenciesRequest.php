<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Country;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * @see https://digistore24.com/api/docs/paths/listCurrencies.yaml
 */
final class ListCurrenciesRequest extends AbstractRequest
{
    public function __construct(
        private ?string $convertTo = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listCurrencies';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $params = [];
        if ($this->convertTo !== null) {
            $params['convert_to'] = $this->convertTo;
        }

        return $params;
    }
}
