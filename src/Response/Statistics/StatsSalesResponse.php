<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stats Sales Response
 *
 * Response object for the Statistics API endpoint.
 */
final class StatsSalesResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Sales data
     *
     * @var array<string, mixed>
     */
    public array $sales = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $sales = $innerData['sales'] ?? [];

        if (! is_array($sales)) {
            $sales = [];
        }
        /** @var array<string, mixed> $validatedSales */
        $validatedSales = $sales;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->sales = $validatedSales;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
