<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\PurchaseSearchData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Enum\PurchaseSortBy;
use GoSuccess\Digistore24\Api\Enum\SortOrder;

/**
 * List Purchases Request
 *
 * Lists all purchases/orders in the account with extensive filtering and pagination options.
 */
final class ListPurchasesRequest extends AbstractRequest
{
    /**
     * @param string $from Start time for purchase list (e.g. "2014-02-28 23:11:24", "now", "-3d", "start")
     * @param string $to End time for purchase list
     * @param PurchaseSearchData|null $search Search criteria for filtering purchases
     * @param PurchaseSortBy $sortBy Sort criteria
     * @param SortOrder $sortOrder Sort order
     * @param bool $loadTransactions Include transaction list for each purchase
     * @param int $pageNo Page number (starts at 1)
     * @param int $pageSize Number of items per page
     */
    public function __construct(
        public readonly string $from = '-24h',
        public readonly string $to = 'now',
        public readonly ?PurchaseSearchData $search = null,
        public readonly PurchaseSortBy $sortBy = PurchaseSortBy::DATE,
        public readonly SortOrder $sortOrder = SortOrder::ASC,
        public readonly bool $loadTransactions = false,
        public readonly int $pageNo = 1,
        public readonly int $pageSize = 500,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listPurchases';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $data = [
            'from' => $this->from,
            'to' => $this->to,
            'sort_by' => $this->sortBy->value,
            'sort_order' => $this->sortOrder->value,
            'load_transactions' => $this->loadTransactions,
            'page_no' => $this->pageNo,
            'page_size' => $this->pageSize,
        ];

        if ($this->search !== null) {
            $data['search'] = $this->search->toArray();
        }

        return $data;
    }
}
