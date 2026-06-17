<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Refund Partially Response
 *
 * Response object for the Purchase API endpoint.
 */
final class RefundPartiallyResponse extends AbstractResponse
{
    public string $result = '';

    public function wasSuccessful(): bool
    {
        return $this->result === 'success';
    }

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
