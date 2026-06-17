<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Enum\StatsPeriod;

/**
 * Stats Sales Request
 *
 * Retrieves detailed sales statistics, grouped into the requested period, for a
 * specified date range.
 *
 * @link https://digistore24.com/api/docs/paths/statsSales.yaml
 */
final class StatsSalesRequest extends AbstractRequest
{
    /**
     * @param string|null $from Start date for statistics (format: 2017-12-31)
     * @param string|null $to End date for statistics (format: 2017-12-31)
     * @param StatsPeriod|null $period Time period for grouping sales data (default: week)
     */
    public function __construct(
        private ?string $from = null,
        private ?string $to = null,
        private ?StatsPeriod $period = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/statsSales';
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
        if ($this->period !== null) {
            $params['period'] = $this->period->value;
        }

        return $params;
    }
}
