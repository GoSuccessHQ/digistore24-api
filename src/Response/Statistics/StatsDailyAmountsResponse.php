<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Statistics;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\DailyAmountData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stats Daily Amounts Response
 *
 * Response for statsDailyAmounts. Exposes the daily revenue records under
 * `amountList` (spec key: data.amount_list) as typed {@see DailyAmountData}.
 *
 * @link https://digistore24.com/api/docs/paths/statsDailyAmounts.yaml
 */
final class StatsDailyAmountsResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The daily revenue records as typed DTOs.
     *
     * @var array<int, DailyAmountData>
     */
    public array $amountList = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        // Spec key is `amount_list`; fall back to the legacy `daily_amounts` shape.
        $items = $innerData['amount_list'] ?? $innerData['daily_amounts'] ?? [];
        if (! is_array($items)) {
            $items = [];
        }

        $amountList = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }
            /** @var array<string, mixed> $validatedItem */
            $validatedItem = $item;
            $amountList[] = DailyAmountData::fromArray($validatedItem);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->amountList = $amountList;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
