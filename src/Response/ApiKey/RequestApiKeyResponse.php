<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Request API Key Response
 *
 * Response object for the requestApiKey API endpoint. Mirrors the spec's `data`
 * object: the URL the user must visit to confirm the new key and the token used
 * later to retrieve the key via retrieveApiKey.
 *
 * @link https://digistore24.com/api/docs/paths/requestApiKey.yaml
 */
final class RequestApiKeyResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * URL to direct the user to in order to create the API key
     */
    public ?string $requestUrl = null;

    /**
     * Token to save for later retrieval of the API key via retrieveApiKey
     */
    public ?string $requestToken = null;

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

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->requestUrl = TypeConverter::toString($innerData['request_url'] ?? null);
        $response->requestToken = TypeConverter::toString($innerData['request_token'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
