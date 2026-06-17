<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stats Sales Summary Response
 *
 * Response for statsSalesSummary. The figures are returned under `for`, an
 * object keyed by time bucket (all, year, quarter, month, week, day); each
 * bucket holds `from`, `to`, an `amounts` map keyed by currency, and the
 * `percentages`/`references` comparison maps. Performance metrics are returned
 * under `call_duration_ms`.
 *
 * Because the payload is a deeply nested, dynamically keyed structure, the
 * buckets are exposed as documented associative arrays rather than flat DTOs.
 *
 * @link https://digistore24.com/api/docs/paths/statsSalesSummary.yaml
 */
final class StatsSalesSummaryResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Statistics keyed by time bucket (all, year, quarter, month, week, day).
     * Each bucket contains `from`, `to`, `amounts` (keyed by currency),
     * `percentages` and `references`.
     *
     * @var array<string, mixed>
     */
    public array $for = [];

    /**
     * Per-section calculation durations in milliseconds (e.g. amount_for_all,
     * amount_for_year, percentages, total_call).
     *
     * @var array<string, mixed>
     */
    public array $callDurationMs = [];

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

        // Spec key is `for`; fall back to the legacy `summary` shape.
        $for = $validatedData['for'] ?? $validatedData['summary'] ?? [];
        if (! is_array($for)) {
            $for = [];
        }
        $callDuration = $validatedData['call_duration_ms'] ?? [];
        if (! is_array($callDuration)) {
            $callDuration = [];
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        /** @var array<string, mixed> $for */
        $response->for = $for;
        /** @var array<string, mixed> $callDuration */
        $response->callDurationMs = $callDuration;
        $response->data = $validatedData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
