<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Rebilling Status Changes Request
 *
 * Retrieves a list of rebilling status changes within a date range.
 */
final class ListRebillingStatusChangesRequest extends AbstractRequest
{
    /**
     * @param string|null $from Start date for the range (format: YYYY-MM-DD)
     * @param string|null $to End date for the range (format: YYYY-MM-DD)
     */
    public function __construct(private ?string $from = null, private ?string $to = null)
    {
    }

    public function getEndpoint(): string
    {
        return '/listRebillingStatusChanges';
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
