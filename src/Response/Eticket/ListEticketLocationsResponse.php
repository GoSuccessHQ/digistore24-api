<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List E-Ticket Locations Response
 *
 * Response containing a list of e-ticket locations. The API returns an array of
 * location objects directly.
 *
 * @link https://digistore24.com/api/docs/paths/listEticketLocations.yaml
 */
final class ListEticketLocationsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<int, EticketLocation> Array of e-ticket locations */
    public array $locations = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        // The API returns a bare array of locations. Support a `locations`
        // wrapper too for forward compatibility and direct fromArray() calls.
        $items = $data['locations'] ?? $data;
        $locations = [];

        if (is_array($items)) {
            foreach ($items as $location) {
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
