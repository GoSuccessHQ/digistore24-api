<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Stats Affiliate Toplist Request
 *
 * Retrieves a ranked list of top-performing affiliates for a month range.
 *
 * @link https://digistore24.com/api/docs/paths/statsAffiliateToplist.yaml
 */
final class StatsAffiliateToplistRequest extends AbstractRequest
{
    /**
     * @param string|null $from Start month for the report, format YYYY-MM (e.g. 2015-01). Required by the API.
     * @param string|null $to End month for the report, format YYYY-MM (e.g. 2015-12). Required by the API.
     * @param string|null $affiliate Digistore identifier of a particular affiliate to filter by
     * @param string|null $currency Currency code for revenue display (USD, EUR, GBP, CHF, PLN)
     */
    public function __construct(
        private ?string $from = null,
        private ?string $to = null,
        private ?string $affiliate = null,
        private ?string $currency = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/statsAffiliateToplist';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $params = [];
        if ($this->from !== null) {
            $params['from'] = $this->from;
        }
        if ($this->to !== null) {
            $params['to'] = $this->to;
        }
        if ($this->affiliate !== null) {
            $params['affiliate'] = $this->affiliate;
        }
        if ($this->currency !== null) {
            $params['currency'] = $this->currency;
        }

        return $params;
    }
}
