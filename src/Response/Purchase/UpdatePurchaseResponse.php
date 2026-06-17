<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Update Purchase Response
 *
 * Response object for the Purchase API endpoint.
 */
final class UpdatePurchaseResponse extends AbstractResponse
{
    public string $result = '';

    public string $isModified = 'N';

    public function wasModified(): bool
    {
        return $this->isModified === 'Y';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $isModified = $innerData['is_modified'] ?? 'N';

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->isModified = is_string($isModified) ? $isModified : 'N';
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
