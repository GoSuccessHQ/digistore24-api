<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Request API Key Request
 *
 * Requests a new API key for the specified email address.
 * A token will be sent to the email to verify ownership.
 */
final class RequestApiKeyRequest extends AbstractRequest
{
    /**
     * @param string $email The vendor email address
     */
    public function __construct(
        private string $email,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/requestApiKey';
    }

    public function toArray(): array
    {
        return ['email' => $this->email];
    }
}
