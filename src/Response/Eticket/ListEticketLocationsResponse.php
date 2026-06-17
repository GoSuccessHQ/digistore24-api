<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List E-Ticket Locations Response
 *
 * Response containing a list of e-ticket locations.
 */
final class ListEticketLocationsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<EticketLocation> Array of e-ticket locations */
    public array $locations = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $locations = [];

        if (isset($data['locations']) && is_array($data['locations'])) {
            foreach ($data['locations'] as $location) {
                if (! is_array($location)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedLocation */
                $validatedLocation = $location;
                $locations[] = EticketLocation::fromArray($validatedLocation);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->locations = $locations;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
