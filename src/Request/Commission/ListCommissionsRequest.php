<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Commission;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Request to list affiliate commissions.
 *
 * Returns a list of your Digistore24 commission amounts with flexible filtering
 * by time range, transaction type, commission type, and purchase ID.
 *
 * @see https://digistore24.com/api/docs/paths/listCommissions.yaml
 */
final class ListCommissionsRequest extends AbstractRequest
{
    /**
     * @param string|null $from Start time (e.g., "2014-02-28 23:11:24", "now", "-3d", "start")
     * @param string|null $to End time
     * @param int|null $pageNo Page number for pagination (starts at 1)
     * @param int|null $pageSize Number of items per page (0 for all entries)
     * @param string|null $transactionType Filter by transaction types (e.g., "payment,refund,refund_request,chargeback")
     * @param string|null $commissionType Filter by commission types
     * @param string|null $purchaseId Filter by specific purchase ID
     */
    public function __construct(
        private ?string $from = null,
        private ?string $to = null,
        private ?int $pageNo = null,
        private ?int $pageSize = null,
        private ?string $transactionType = null,
        private ?string $commissionType = null,
        private ?string $purchaseId = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listCommissions';
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

        if ($this->transactionType !== null) {
            $params['transaction_type'] = $this->transactionType;
        }

        if ($this->commissionType !== null) {
            $params['commission_type'] = $this->commissionType;
        }

        if ($this->purchaseId !== null) {
            $params['purchase_id'] = $this->purchaseId;
        }

        return $params;
    }
}
