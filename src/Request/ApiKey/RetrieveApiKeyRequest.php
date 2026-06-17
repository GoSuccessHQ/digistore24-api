<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Retrieve API Key Request
 *
 * Retrieves the API key for a request token previously obtained from
 * requestApiKey, once the user has confirmed the key creation.
 *
 * @link https://digistore24.com/api/docs/paths/retrieveApiKey.yaml
 */
final class RetrieveApiKeyRequest extends AbstractRequest
{
    /**
     * @param string $token The request token returned by requestApiKey
     */
    public function __construct(
        public string $token,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/retrieveApiKey';
    }

    public function toArray(): array
    {
        return ['token' => $this->token];
    }
}
