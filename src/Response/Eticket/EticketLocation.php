<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * E-Ticket Location
 *
 * Represents an e-ticket location as returned by listEticketLocations.
 *
 * @link https://digistore24.com/api/docs/paths/listEticketLocations.yaml
 */
final class EticketLocation
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $address,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return static
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        return new self(
            id: TypeConverter::toInt($data['id'] ?? null, 0) ?? 0,
            name: TypeConverter::toString($data['name'] ?? null, '') ?? '',
            address: TypeConverter::toString($data['address'] ?? null, '') ?? '',
        );
    }
}
