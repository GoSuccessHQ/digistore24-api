<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use DateTimeInterface;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * E-Ticket Template
 *
 * Represents an e-ticket template as returned by listEticketTemplates.
 *
 * @link https://digistore24.com/api/docs/paths/listEticketTemplates.yaml
 */
final class EticketTemplate
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?DateTimeInterface $createdAt,
        public readonly ?DateTimeInterface $modifiedAt,
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
            createdAt: TypeConverter::toDateTime($data['created_at'] ?? null),
            modifiedAt: TypeConverter::toDateTime($data['modified_at'] ?? null),
        );
    }
}
