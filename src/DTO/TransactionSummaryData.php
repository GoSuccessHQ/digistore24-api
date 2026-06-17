<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Transaction Summary Data
 *
 * The `summary` object returned by listTransactions. Aggregates the matched
 * transactions: a total `count` plus per-currency `amounts`. Response-only DTO:
 * all fields use get-only property hooks.
 *
 * The `amounts` map is keyed by currency code; each value is a typed
 * {@see TransactionSummaryAmountData}. Because the keys are dynamic currency
 * codes the reflection hydrator cannot type them automatically, so
 * {@see self::fromArray()} is overridden to build the typed map.
 *
 * @link https://digistore24.com/api/docs/paths/listTransactions.yaml
 */
final class TransactionSummaryData extends AbstractDataTransferObject
{
    /**
     * Total number of matched transactions across all currencies.
     */
    public ?int $count = null {
        get => $this->count;
    }

    /**
     * Per-currency aggregates, keyed by currency code.
     *
     * @var array<string, TransactionSummaryAmountData>
     */
    public array $amounts = [] {
        get => $this->amounts;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $instance = new self();
        $instance->count = TypeConverter::toInt($data['count'] ?? null);
        $instance->amounts = self::buildAmounts($data['amounts'] ?? null);

        /** @var static */
        return $instance;
    }

    /**
     * Build the currency-keyed map of amount aggregates.
     *
     * @param mixed $amounts
     * @return array<string, TransactionSummaryAmountData>
     */
    private static function buildAmounts(mixed $amounts): array
    {
        if (! is_array($amounts)) {
            return [];
        }

        $result = [];
        foreach ($amounts as $currency => $amount) {
            if (! is_array($amount)) {
                continue;
            }

            /** @var array<string, mixed> $stringKeyed */
            $stringKeyed = [];
            foreach ($amount as $key => $value) {
                $stringKeyed[(string)$key] = $value;
            }

            $result[(string)$currency] = TransactionSummaryAmountData::fromArray($stringKeyed);
        }

        return $result;
    }
}
