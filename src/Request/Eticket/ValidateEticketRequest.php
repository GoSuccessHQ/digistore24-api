<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Validate E-Ticket Request
 *
 * Validates (scans) an e-ticket, marking it as used.
 */
final class ValidateEticketRequest extends AbstractRequest
{
    public function __construct(
        public readonly string $ticketId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/validateEticket';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
