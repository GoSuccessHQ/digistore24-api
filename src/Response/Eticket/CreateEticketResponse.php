<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create E-Ticket Response
 *
 * Response after successfully creating e-tickets.
 */
final class CreateEticketResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<EticketItem> List of created e-tickets */
    public array $etickets = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $etickets = [];
        if (isset($data['etickets']) && is_array($data['etickets'])) {
            foreach ($data['etickets'] as $item) {
                if (is_array($item)) {
                    /** @var array<string, mixed> $validatedItem */
                    $validatedItem = $item;
                    $etickets[] = EticketItem::fromArray($validatedItem);
                }
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->etickets = $etickets;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
