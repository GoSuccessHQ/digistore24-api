<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Request Api Key Response
 *
 * Response object for the requestApiKey API endpoint.
 */
final class RequestApiKeyResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * The generated API key
     */
    public string $apiKey = '';

    /**
     * Creation timestamp
     */
    public ?\DateTimeInterface $createdAt = null;

    /**
     * API key description
     */
    public ?string $description = null;

    /**
     * API key permissions
     *
     * @var array<string>
     */
    public array $permissions = [];

    /**
     * Rate limit for this API key
     */
    public ?int $rateLimit = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->apiKey = is_string($innerData['api_key'] ?? null) ? $innerData['api_key'] : '';
        $response->createdAt = TypeConverter::toDateTime($innerData['created_at'] ?? null);
        $response->description = is_string($innerData['description'] ?? null) ? $innerData['description'] : null;

        $permissions = $innerData['permissions'] ?? [];
        if (is_array($permissions)) {
            $response->permissions = array_filter($permissions, 'is_string');
        } else {
            $response->permissions = [];
        }

        $response->rateLimit = TypeConverter::toInt($innerData['rate_limit'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
