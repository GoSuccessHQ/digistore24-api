<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Enum\ApiRequestStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Retrieve API Key Response
 *
 * Response object for the retrieveApiKey API endpoint. Mirrors the spec's `data`
 * object: the new API key (empty string when the token is invalid, too old or
 * already used), the status of the request and a note explaining the outcome.
 *
 * @link https://digistore24.com/api/docs/paths/retrieveApiKey.yaml
 */
final class RetrieveApiKeyResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * The new API key, or an empty string if the token is invalid, too old or
     * has already been used.
     */
    public string $apiKey = '';

    /**
     * Status of the API key request
     */
    public ?ApiRequestStatus $requestStatus = null;

    /**
     * Cause indication when no API key is returned
     */
    public ?string $note = null;

    /**
     * The complete payload as returned by the API, so every field is accessible
     * even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $requestStatus = null;
        if (isset($innerData['request_status']) && is_string($innerData['request_status'])) {
            $requestStatus = ApiRequestStatus::fromString($innerData['request_status']);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->apiKey = TypeConverter::toString($innerData['api_key'] ?? null) ?? '';
        $response->requestStatus = $requestStatus;
        $response->note = TypeConverter::toString($innerData['note'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
