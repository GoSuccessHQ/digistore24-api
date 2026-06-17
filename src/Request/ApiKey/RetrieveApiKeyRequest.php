<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Retrieve API Key Request
 *
 * Retrieves the API key using the email and verification token.
 */
final class RetrieveApiKeyRequest extends AbstractRequest
{
    /**
     * @param string $email The vendor email address
     * @param string $token The verification token received via email
     */
    public function __construct(
        private string $email,
        private string $token,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/retrieveApiKey';
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'token' => $this->token,
        ];
    }
}
