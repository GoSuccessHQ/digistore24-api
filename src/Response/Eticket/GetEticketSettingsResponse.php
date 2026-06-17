<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get E-Ticket Settings Response
 *
 * Response containing the e-ticket configuration available to the account:
 * the owners that grant e-ticket access, and the templates and locations
 * grouped by owner ID.
 *
 * @link https://digistore24.com/api/docs/paths/getEticketSettings.yaml
 */
final class GetEticketSettingsResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Maps Digistore24 account IDs to owner names.
     *
     * @var array<string, mixed>
     */
    public array $eticketOwners = [];

    /**
     * Templates grouped by owner ID: owner_id => (template_id => template_name).
     *
     * @var array<string, mixed>
     */
    public array $eticketTemplates = [];

    /**
     * Locations grouped by owner ID: owner_id => (location_id => location_name).
     *
     * @var array<string, mixed>
     */
    public array $eticketLocations = [];

    /**
     * The complete settings payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $inner = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->eticketOwners = self::toStringKeyedArray($inner['eticket_owners'] ?? null);
        $response->eticketTemplates = self::toStringKeyedArray($inner['eticket_templates'] ?? null);
        $response->eticketLocations = self::toStringKeyedArray($inner['eticket_locations'] ?? null);
        $response->data = $inner;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @param mixed $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
