<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Rebilling Status Changes Request
 *
 * Retrieves a paginated list of rebilling status changes within a time range.
 *
 * @link https://digistore24.com/api/docs/paths/listRebillingStatusChanges.yaml
 */
final class ListRebillingStatusChangesRequest extends AbstractRequest
{
    /**
     * @param string|null $from Start time for the query (e.g. '2014-02-28 23:11:24', 'now', '-3d', 'start'; default '-24h')
     * @param string|null $to End time for the query (default 'now')
     * @param int|null $pageNo Page number, starting at 1 (default 1)
     * @param int|null $pageSize Number of entries per page (default 100)
     */
    public function __construct(
        private ?string $from = null,
        private ?string $to = null,
        private ?int $pageNo = null,
        private ?int $pageSize = null,
    ) {
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
        if ($this->pageNo !== null) {
            $params['page_no'] = $this->pageNo;
        }
        if ($this->pageSize !== null) {
            $params['page_size'] = $this->pageSize;
        }

        return $params;
    }
}
