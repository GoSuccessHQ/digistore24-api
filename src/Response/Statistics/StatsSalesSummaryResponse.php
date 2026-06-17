<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stats Sales Summary Response
 *
 * Response object for the Statistics API endpoint.
 */
final class StatsSalesSummaryResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Summary data
     *
     * @var array<string, mixed>
     */
    public array $summary = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $summary = $innerData['summary'] ?? [];

        if (! is_array($summary)) {
            $summary = [];
        }
        /** @var array<string, mixed> $validatedSummary */
        $validatedSummary = $summary;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->summary = $validatedSummary;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
