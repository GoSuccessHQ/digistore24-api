<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Retrieve Api Key Response
 *
 * Response object for retrieving API key information.
 */
final class RetrieveApiKeyResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * The API key ID
     */
    public string $apiKeyId = '';

    /**
     * API key description
     */
    public ?string $description = null;

    /**
     * Creation timestamp
     */
    public ?\DateTimeInterface $createdAt = null;

    /**
     * Last usage timestamp
     */
    public ?\DateTimeInterface $lastUsedAt = null;

    /**
     * Whether the API key is active
     */
    public bool $isActive = false;

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

    /**
     * Number of requests made today
     */
    public ?int $requestsToday = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->apiKeyId = is_string($innerData['api_key_id'] ?? null) ? $innerData['api_key_id'] : '';
        $response->description = is_string($innerData['description'] ?? null) ? $innerData['description'] : null;
        $response->createdAt = TypeConverter::toDateTime($innerData['created_at'] ?? null);
        $response->lastUsedAt = TypeConverter::toDateTime($innerData['last_used_at'] ?? null);
        $response->isActive = (bool)($innerData['is_active'] ?? false);

        $permissions = $innerData['permissions'] ?? [];
        if (is_array($permissions)) {
            $response->permissions = array_filter($permissions, 'is_string');
        } else {
            $response->permissions = [];
        }

        $response->rateLimit = TypeConverter::toInt($innerData['rate_limit'] ?? null);
        $response->requestsToday = TypeConverter::toInt($innerData['requests_today'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
