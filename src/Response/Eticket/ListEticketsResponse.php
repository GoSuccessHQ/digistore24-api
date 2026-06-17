<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List E-Tickets Response
 *
 * Response containing a list of e-tickets.
 */
final class ListEticketsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<EticketListItem> Array of e-ticket list items */
    public array $tickets = [];

    /** Total number of tickets matching the filter */
    public int $totalCount = 0;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $tickets = [];

        $ticketsData = $innerData['tickets'] ?? [];

        if (is_array($ticketsData)) {
            foreach ($ticketsData as $ticket) {
                if (! is_array($ticket)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedTicket */
                $validatedTicket = $ticket;
                $tickets[] = EticketListItem::fromArray($validatedTicket);
            }
        }

        $totalCount = $innerData['total_count'] ?? count($tickets);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->tickets = $tickets;
        $response->totalCount = TypeConverter::toInt($totalCount) ?? count($tickets);
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
