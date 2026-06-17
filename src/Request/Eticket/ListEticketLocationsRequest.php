<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List E-Ticket Locations Request
 *
 * Lists all available e-ticket locations.
 */
final class ListEticketLocationsRequest extends AbstractRequest
{
    public function getEndpoint(): string
    {
        return '/listEticketLocations';
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
