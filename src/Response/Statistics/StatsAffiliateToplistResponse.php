<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stats Affiliate Toplist Response
 *
 * Response object for the Statistics API endpoint.
 */
final class StatsAffiliateToplistResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Toplist data
     *
     * @var array<string, mixed>
     */
    public array $toplist = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $toplist = $innerData['toplist'] ?? [];

        if (! is_array($toplist)) {
            $toplist = [];
        }
        /** @var array<string, mixed> $validatedToplist */
        $validatedToplist = $toplist;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->toplist = $validatedToplist;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
