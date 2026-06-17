<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stats Daily Amounts Response
 *
 * Response object for the Statistics API endpoint.
 */
final class StatsDailyAmountsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Daily amounts data
     *
     * @var array<string, mixed>
     */
    public array $dailyAmounts = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $dailyAmounts = $innerData['daily_amounts'] ?? [];

        if (! is_array($dailyAmounts)) {
            $dailyAmounts = [];
        }
        /** @var array<string, mixed> $validatedAmounts */
        $validatedAmounts = $dailyAmounts;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->dailyAmounts = $validatedAmounts;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
