<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Transaction;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\TransactionSearchData;
use GoSuccess\Digistore24\Api\Enum\SortOrder;
use GoSuccess\Digistore24\Api\Enum\TransactionSortBy;

/**
 * List Transactions Request
 *
 * Retrieves a paginated and filterable list of transactions.
 */
final class ListTransactionsRequest extends AbstractRequest
{
    /**
     * @param string $from Start time for transaction list (e.g. "2014-02-28 23:11:24", "now", "-3d", "start")
     * @param string $to End time for transaction list
     * @param TransactionSearchData|null $search Search criteria for filtering transactions
     * @param TransactionSortBy $sortBy Sort criteria
     * @param SortOrder $sortOrder Sort order
     * @param int $pageNo Page number (starts at 1)
     * @param int $pageSize Number of items per page
     */
    public function __construct(
        private string $from = '-24h',
        private string $to = 'now',
        private ?TransactionSearchData $search = null,
        private TransactionSortBy $sortBy = TransactionSortBy::DATE,
        private SortOrder $sortOrder = SortOrder::ASC,
        private int $pageNo = 1,
        private int $pageSize = 500,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listTransactions';
    }

    public function toArray(): array
    {
        $params = [
            'from' => $this->from,
            'to' => $this->to,
            'sort_by' => $this->sortBy->value,
            'sort_order' => $this->sortOrder->value,
            'page_no' => $this->pageNo,
            'page_size' => $this->pageSize,
        ];

        if ($this->search !== null) {
            $params['search'] = $this->search->toArray();
        }

        return $params;
    }
}
