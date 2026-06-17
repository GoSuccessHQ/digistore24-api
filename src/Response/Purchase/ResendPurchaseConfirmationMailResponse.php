<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Resend Purchase Confirmation Mail Response
 *
 * Response object for the Purchase API endpoint.
 */
final class ResendPurchaseConfirmationMailResponse extends AbstractResponse
{
    public string $result = '';

    public string $modified = 'N';

    public ?string $note = null;

    public function wasSuccessful(): bool
    {
        return $this->modified === 'Y';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $modified = $innerData['modified'] ?? 'N';
        $note = $innerData['note'] ?? null;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->modified = is_string($modified) ? $modified : 'N';
        $response->note = $note !== null && is_string($note) ? $note : null;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
