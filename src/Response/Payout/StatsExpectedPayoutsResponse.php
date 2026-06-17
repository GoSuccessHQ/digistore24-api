<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Payout;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stats Expected Payouts Response
 *
 * Statistics about expected upcoming payouts. The amount fields are keyed by
 * currency code, so they are surfaced as associative arrays. The complete
 * payload is also available via {@see $data}.
 *
 * @link https://digistore24.com/api/docs/paths/statsExpectedPayouts.yaml
 */
final class StatsExpectedPayoutsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Total earnings, keyed by currency code (spec key: `total_earnings`)
     *
     * @var array<string, mixed>
     */
    public array $totalEarnings = [];

    /**
     * Amount already paid out, keyed by currency code (spec key: `paidout_amount`)
     *
     * @var array<string, mixed>
     */
    public array $paidoutAmount = [];

    /**
     * Amount still pending, keyed by currency code (spec key: `pending_amount`)
     *
     * @var array<string, mixed>
     */
    public array $pendingAmount = [];

    /**
     * Future amounts grouped by payout date, each holding amount/can_payout/treshold/note
     *
     * @var array<string, mixed>
     */
    public array $futureAmounts = [];

    /**
     * Per-reseller payout breakdown (spec key: `by_reseller`)
     *
     * @var array<int, mixed>
     */
    public array $byReseller = [];

    /**
     * Payout note with `message` and `reasons`
     *
     * @var array<string, mixed>
     */
    public array $note = [];

    /**
     * Internal call durations in milliseconds (spec key: `call_duration_ms`)
     *
     * @var array<string, mixed>
     */
    public array $callDurationMs = [];

    /**
     * The complete payload as returned by the API, so every field is accessible
     * even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->totalEarnings = self::toAssocArray($innerData['total_earnings'] ?? null);
        $response->paidoutAmount = self::toAssocArray($innerData['paidout_amount'] ?? null);
        $response->pendingAmount = self::toAssocArray($innerData['pending_amount'] ?? null);
        $response->futureAmounts = self::toAssocArray($innerData['future_amounts'] ?? null);
        $response->byReseller = self::toListArray($innerData['by_reseller'] ?? null);
        $response->note = self::toAssocArray($innerData['note'] ?? null);
        $response->callDurationMs = self::toAssocArray($innerData['call_duration_ms'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @return array<string, mixed>
     */
    private static function toAssocArray(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }

    /**
     * @return array<int, mixed>
     */
    private static function toListArray(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values($value);
    }
}
