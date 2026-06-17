<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get E-Ticket Response
 *
 * Response containing e-ticket details.
 */
final class GetEticketResponse extends AbstractResponse
{
    public string $result = '';

    public EticketDetail $ticket;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        // Support both direct and nested data structures
        $ticketData = $data['data'] ?? $data;
        if (! is_array($ticketData)) {
            $ticketData = [];
        }
        /** @var array<string, mixed> $validatedTicketData */
        $validatedTicketData = $ticketData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->ticket = EticketDetail::fromArray($validatedTicketData);
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
