<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Payout;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Payouts Response
 *
 * Response object for the Payout API endpoint.
 */
final class ListPayoutsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Payout list
     *
     * @var array<string, mixed>
     */
    public array $payoutList = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $payoutList = $innerData['payout_list'] ?? [];

        if (! is_array($payoutList)) {
            $payoutList = [];
        }

        /** @var array<string, mixed> $validatedPayoutList */
        $validatedPayoutList = $payoutList;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->payoutList = $validatedPayoutList;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
