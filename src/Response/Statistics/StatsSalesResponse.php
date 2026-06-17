<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\PeriodAmountData;
use GoSuccess\Digistore24\Api\Enum\StatsPeriod;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Stats Sales Response
 *
 * Response for statsSales. The revenue figures are returned under `amounts`,
 * an object keyed by currency code whose values are arrays of period buckets
 * ({@see PeriodAmountData}). The overall date range and grouping period are also
 * exposed.
 *
 * @link https://digistore24.com/api/docs/paths/statsSales.yaml
 */
final class StatsSalesResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Revenue figures keyed by currency code; each value is the list of period
     * buckets for that currency.
     *
     * @var array<string, array<int, PeriodAmountData>>
     */
    public array $amounts = [];

    /**
     * Overall statistics start date (format: YYYY-MM-DD).
     */
    public ?string $from = null;

    /**
     * Overall statistics end date (format: YYYY-MM-DD).
     */
    public ?string $to = null;

    /**
     * Grouping period used for the buckets.
     */
    public ?StatsPeriod $period = null;

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
        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->amounts = self::buildAmounts($validatedData['amounts'] ?? null);
        $response->from = TypeConverter::toString($validatedData['from'] ?? null);
        $response->to = TypeConverter::toString($validatedData['to'] ?? null);
        $response->period = StatsPeriod::fromString(TypeConverter::toString($validatedData['period'] ?? null));
        $response->data = $validatedData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * Build the currency-keyed map of period buckets.
     *
     * @param mixed $amounts
     * @return array<string, array<int, PeriodAmountData>>
     */
    private static function buildAmounts(mixed $amounts): array
    {
        if (! is_array($amounts)) {
            return [];
        }

        $result = [];
        foreach ($amounts as $currency => $buckets) {
            if (! is_array($buckets)) {
                continue;
            }

            $periods = [];
            foreach ($buckets as $bucket) {
                if (! is_array($bucket)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedBucket */
                $validatedBucket = $bucket;
                $periods[] = PeriodAmountData::fromArray($validatedBucket);
            }

            $result[(string)$currency] = $periods;
        }

        return $result;
    }
}
