<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Commission;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Response containing list of affiliate commissions.
 *
 * @see https://digistore24.com/api/docs/paths/listCommissions.yaml
 */
final class ListCommissionsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Current page number
     */
    public int $pageNo = 1;

    /**
     * Number of items per page
     */
    public int $pageSize = 0;

    /**
     * Total number of items
     */
    public int $itemCount = 0;

    /**
     * Total number of pages
     */
    public int $pageCount = 0;

    /**
     * Commission items
     *
     * @var array<int, object{id: int, created_at: string, amount: float, currency: string, reason: string, schedule_payout_at: string, transaction_id: int, purchase_id: string}>
     */
    public array $items = [];

    /**
     * Check if there are more pages.
     */
    public function hasMorePages(): bool
    {
        return $this->pageNo < $this->pageCount;
    }

    /**
     * Get total commission amount.
     */
    public function getTotalAmount(): float
    {
        return array_reduce(
            $this->items,
            fn ($sum, $item) => $sum + $item->amount,
            0.0,
        );
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $items = [];
        $itemsData = $innerData['items'] ?? [];
        if (is_array($itemsData)) {
            foreach ($itemsData as $item) {
                if (! is_array($item)) {
                    continue;
                }

                $id = $item['id'] ?? 0;
                $createdAt = $item['created_at'] ?? '';
                $amount = $item['amount'] ?? 0.0;
                $currency = $item['currency'] ?? '';
                $reason = $item['reason'] ?? '';
                $schedulePayoutAt = $item['schedule_payout_at'] ?? '';
                $transactionId = $item['transaction_id'] ?? 0;
                $purchaseId = $item['purchase_id'] ?? '';

                $items[] = (object)[
                    'id' => TypeConverter::toInt($id) ?? 0,
                    'created_at' => TypeConverter::toString($createdAt) ?? '',
                    'amount' => TypeConverter::toFloat($amount) ?? 0.0,
                    'currency' => TypeConverter::toString($currency) ?? '',
                    'reason' => TypeConverter::toString($reason) ?? '',
                    'schedule_payout_at' => TypeConverter::toString($schedulePayoutAt) ?? '',
                    'transaction_id' => TypeConverter::toInt($transactionId) ?? 0,
                    'purchase_id' => TypeConverter::toString($purchaseId) ?? '',
                ];
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->pageNo = TypeConverter::toInt($innerData['page_no'] ?? 1) ?? 1;
        $response->pageSize = TypeConverter::toInt($innerData['page_size'] ?? 0) ?? 0;
        $response->itemCount = TypeConverter::toInt($innerData['item_count'] ?? 0) ?? 0;
        $response->pageCount = TypeConverter::toInt($innerData['page_count'] ?? 0) ?? 0;
        $response->items = $items;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
