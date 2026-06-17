<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Rebilling Status Changes Response
 *
 * Response object for the Rebilling API endpoint.
 */
final class ListRebillingStatusChangesResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Status changes array
     *
     * @var array<string, mixed>
     */
    public array $statusChanges = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $statusChanges = $innerData['status_changes'] ?? [];

        if (! is_array($statusChanges)) {
            $statusChanges = [];
        }

        /** @var array<string, mixed> $validatedStatusChanges */
        $validatedStatusChanges = $statusChanges;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->statusChanges = $validatedStatusChanges;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
