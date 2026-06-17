<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create Rebilling Payment Response
 *
 * Response object for the Rebilling API endpoint.
 */
final class CreateRebillingPaymentResponse extends AbstractResponse
{
    /**
     * Result status
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
