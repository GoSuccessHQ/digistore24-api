<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Buyer;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Buyer Response
 *
 * Response object for the Buyer API endpoint.
 */
final class GetBuyerResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Buyer data
     */
    public ?BuyerData $buyer = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $buyerData = $innerData['buyer'] ?? [];

        if (! is_array($buyerData)) {
            $buyerData = [];
        }

        /** @var array<string, mixed> $validBuyerData */
        $validBuyerData = $buyerData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->buyer = BuyerData::fromArray($validBuyerData);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
