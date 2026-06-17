<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Billing;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Response from partially refunding a purchase.
 *
 * Contains the result of the partial refund operation.
 * The order status does not change with partial refunds.
 *
 * @see https://digistore24.com/api/docs/paths/refundPartially.yaml
 */
final class RefundPartiallyResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
