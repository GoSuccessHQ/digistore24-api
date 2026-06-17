<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Invoice;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Resend Invoice Mail Response
 *
 * Response object for the Invoice API endpoint.
 */
final class ResendInvoiceMailResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Status
     */
    public string $status = '';

    /**
     * Note
     */
    public string $note = '';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->status = is_string($innerData['status'] ?? null) ? $innerData['status'] : '';
        $response->note = is_string($innerData['note'] ?? null) ? $innerData['note'] : '';

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
