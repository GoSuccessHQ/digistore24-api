<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Stats Affiliate Toplist Request
 *
 * Retrieves a ranked list of top-performing affiliates for a date range.
 */
final class StatsAffiliateToplistRequest extends AbstractRequest
{
    /**
     * @param string|null $from Start date for statistics (format: YYYY-MM-DD)
     * @param string|null $to End date for statistics (format: YYYY-MM-DD)
     * @param int|null $limit Maximum number of affiliates to return
     */
    public function __construct(
        private ?string $from = null,
        private ?string $to = null,
        private ?int $limit = null,
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
        if ($this->limit !== null) {
            $params['limit'] = $this->limit;
        }

        return $params;
    }
}
