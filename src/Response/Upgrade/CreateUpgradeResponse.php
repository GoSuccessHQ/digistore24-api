<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create Upgrade Response
 *
 * Response object for the Upgrade API endpoint.
 */
final class CreateUpgradeResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function getUpgradeId(): ?string
    {
        $value = $this->data['upgrade_id'] ?? null;

        return is_string($value) ? $value : null;
    }

    public function wasSuccessful(): bool
    {
        return $this->result === 'success';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $responseData = $data['data'] ?? [];
        if (! is_array($responseData)) {
            $responseData = [];
        }
        /** @var array<string, mixed> $validatedData */
        $validatedData = $responseData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $validatedData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
