<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get E-Ticket Settings Request
 *
 * Retrieves e-ticket configuration settings.
 */
final class GetEticketSettingsRequest extends AbstractRequest
{
    public function getEndpoint(): string
    {
        return '/getEticketSettings';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return [];
    }
}
