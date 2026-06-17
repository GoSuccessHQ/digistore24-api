<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Stats Sales Request
 *
 * Retrieves detailed sales statistics for a specified date range.
 */
final class StatsSalesRequest extends AbstractRequest
{
    /**
     * @param string|null $from Start date for statistics (format: YYYY-MM-DD)
     * @param string|null $to End date for statistics (format: YYYY-MM-DD)
     */
    public function __construct(private ?string $from = null, private ?string $to = null)
    {
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

        return $params;
    }
}
