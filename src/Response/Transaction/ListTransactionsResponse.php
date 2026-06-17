<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Transaction;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\TransactionData;
use GoSuccess\Digistore24\Api\DTO\TransactionSummaryData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Transactions Response
 *
 * Response containing a paginated, filterable list of transactions. Mirrors the
 * `data` object of the spec's listTransactions response.
 *
 * @link https://digistore24.com/api/docs/paths/listTransactions.yaml
 */
final class ListTransactionsResponse extends AbstractResponse
{
    /**
     * Result status.
     */
    public string $result = '';

    /**
     * Start of the queried time range.
     */
    public ?DateTimeImmutable $from = null;

    /**
     * End of the queried time range.
     */
    public ?DateTimeImmutable $to = null;

    /**
     * Number of items per page.
     */
    public ?int $pageSize = null;

    /**
     * Current page number.
     */
    public ?int $pageNo = null;

    /**
     * Total number of pages.
     */
    public ?int $pageCount = null;

    /**
     * Aggregated totals for the matched transactions.
     */
    public ?TransactionSummaryData $summary = null;

    /**
     * The transactions on the current page.
     *
     * @var array<int, TransactionData>
     */
    public array $transactionList = [];

    /**
     * The complete inner payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $summary = is_array($innerData['summary'] ?? null) ? $innerData['summary'] : null;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->from = TypeConverter::toDateTime($innerData['from'] ?? null);
        $response->to = TypeConverter::toDateTime($innerData['to'] ?? null);
        $response->pageSize = TypeConverter::toInt($innerData['page_size'] ?? null);
        $response->pageNo = TypeConverter::toInt($innerData['page_no'] ?? null);
        $response->pageCount = TypeConverter::toInt($innerData['page_count'] ?? null);
        $response->summary = $summary !== null
            ? TransactionSummaryData::fromArray(self::toStringKeyedArray($summary))
            : null;
        $response->transactionList = self::buildTransactions($innerData['transaction_list'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @param mixed $transactions
     * @return array<int, TransactionData>
     */
    private static function buildTransactions(mixed $transactions): array
    {
        if (! is_array($transactions)) {
            return [];
        }

        $result = [];
        foreach ($transactions as $transaction) {
            if (is_array($transaction)) {
                $result[] = TransactionData::fromArray(self::toStringKeyedArray($transaction));
            }
        }

        return $result;
    }

    /**
     * @param array<mixed, mixed> $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(array $value): array
    {
        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
