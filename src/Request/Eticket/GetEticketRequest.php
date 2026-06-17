<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get E-Ticket Request
 *
 * Retrieves details of a specific e-ticket by its e-ticket ID (20 digits).
 *
 * @link https://digistore24.com/api/docs/paths/getEticket.yaml
 */
final class GetEticketRequest extends AbstractRequest
{
    /**
     * @param string $eticketId The e-ticket ID (pattern: 20 digits)
     */
    public function __construct(
        public readonly string $eticketId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/getEticket';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['eticket_id' => $this->eticketId];
    }
}
