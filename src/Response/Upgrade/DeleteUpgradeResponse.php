<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Delete Upgrade Response
 *
 * Response object for the Upgrade API endpoint.
 */
final class DeleteUpgradeResponse extends AbstractResponse
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
