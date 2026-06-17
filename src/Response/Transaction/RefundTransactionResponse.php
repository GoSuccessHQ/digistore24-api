<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Transaction;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Refund Transaction Response
 *
 * Response object for the Transaction API endpoint.
 */
final class RefundTransactionResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Refund status
     */
    public string $status = '';

    /**
     * Whether transaction was modified
     */
    public string $modified = 'N';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->status = is_string($innerData['status'] ?? null) ? $innerData['status'] : '';
        $response->modified = is_string($innerData['modified'] ?? null) ? $innerData['modified'] : 'N';

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
