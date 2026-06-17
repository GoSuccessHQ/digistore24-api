<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Refund Purchase Response
 *
 * Response object for the Purchase API endpoint.
 */
final class RefundPurchaseResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function wasSuccessful(): bool
    {
        return strtolower($this->result) === 'success';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $refundData = $data['data'] ?? [];
        if (! is_array($refundData)) {
            $refundData = [];
        }
        /** @var array<string, mixed> $validatedData */
        $validatedData = $refundData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $validatedData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
