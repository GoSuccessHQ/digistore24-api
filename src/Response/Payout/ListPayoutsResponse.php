<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Payout;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\PayoutData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Payouts Response
 *
 * Contains the list of payout records. Each entry exposes the full spec field
 * set via {@see PayoutData}.
 *
 * @link https://digistore24.com/api/docs/paths/listPayouts.yaml
 */
final class ListPayoutsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Payout records (spec key: `payout_list`)
     *
     * @var array<int, PayoutData>
     */
    public array $payoutList = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $payoutListData = $innerData['payout_list'] ?? [];
        $payoutList = [];

        if (is_array($payoutListData)) {
            foreach ($payoutListData as $item) {
                if (! is_array($item)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedItem */
                $validatedItem = $item;
                $payoutList[] = PayoutData::fromArray($validatedItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->payoutList = $payoutList;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
