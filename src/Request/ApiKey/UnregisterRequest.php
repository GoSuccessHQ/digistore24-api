<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Unregister Request
 *
 * Unregisters and revokes the current API access.
 * The API key will no longer be valid after this call.
 */
final class UnregisterRequest extends AbstractRequest
{
    public function __construct()
    {
    }

    public function getEndpoint(): string
    {
        return '/unregister';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function toArray(): array
    {
        return [];
    }
}
