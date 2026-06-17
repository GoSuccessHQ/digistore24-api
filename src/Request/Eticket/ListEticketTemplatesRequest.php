<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List E-Ticket Templates Request
 *
 * Lists all available e-ticket templates.
 */
final class ListEticketTemplatesRequest extends AbstractRequest
{
    public function getEndpoint(): string
    {
        return '/listEticketTemplates';
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
