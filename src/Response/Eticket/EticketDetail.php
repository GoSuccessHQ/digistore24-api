<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use DateTimeInterface;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * E-Ticket Detail
 *
 * Represents a single e-ticket record as returned by getEticket (and each item
 * of listEtickets). Field names mirror the API's snake_case keys.
 *
 * @link https://digistore24.com/api/docs/paths/getEticket.yaml
 */
final class EticketDetail
{
    /** E-ticket ID */
    public int $id { get => TypeConverter::toInt($this->data['id'] ?? null, 0) ?? 0; }

    /** PDF download URL */
    public string $downloadUrl { get => TypeConverter::toString($this->data['download_url'] ?? null, '') ?? ''; }

    /** Event duration description (nullable) */
    public ?string $duration { get => isset($this->data['duration']) ? TypeConverter::toString($this->data['duration']) : null; }

    /** Date ID */
    public int $dateId { get => TypeConverter::toInt($this->data['date_id'] ?? null, 0) ?? 0; }

    /** Event date (Y-m-d) */
    public ?DateTimeInterface $date { get => TypeConverter::toDateTime($this->data['date'] ?? null); }

    /** Hint / time reference */
    public string $hint { get => TypeConverter::toString($this->data['hint'] ?? null, '') ?? ''; }

    /** Location ID */
    public int $locationId { get => TypeConverter::toInt($this->data['location_id'] ?? null, 0) ?? 0; }

    /** Template ID */
    public int $templateId { get => TypeConverter::toInt($this->data['template_id'] ?? null, 0) ?? 0; }

    /** Purchase item ID */
    public int $purchaseItemId { get => TypeConverter::toInt($this->data['purchase_item_id'] ?? null, 0) ?? 0; }

    /** Sequence number of the ticket within the purchase item */
    public int $no { get => TypeConverter::toInt($this->data['no'] ?? null, 0) ?? 0; }

    /** Number of admissions covered by this ticket */
    public int $count { get => TypeConverter::toInt($this->data['count'] ?? null, 0) ?? 0; }

    /** Buyer email */
    public string $email { get => TypeConverter::toString($this->data['email'] ?? null, '') ?? ''; }

    /** Buyer first name */
    public string $firstName { get => TypeConverter::toString($this->data['first_name'] ?? null, '') ?? ''; }

    /** Buyer last name */
    public string $lastName { get => TypeConverter::toString($this->data['last_name'] ?? null, '') ?? ''; }

    /** Salutation (M or F) */
    public string $salutation { get => TypeConverter::toString($this->data['salutation'] ?? null, '') ?? ''; }

    /** Title (nullable) */
    public ?string $title { get => isset($this->data['title']) ? TypeConverter::toString($this->data['title']) : null; }

    /** Language code */
    public string $language { get => TypeConverter::toString($this->data['language'] ?? null, '') ?? ''; }

    /** Timestamp when the ticket was scanned/used (nullable) */
    public ?DateTimeInterface $usedAt { get => ! empty($this->data['used_at']) ? TypeConverter::toDateTime($this->data['used_at']) : null; }

    /** Whether the ticket is blocked */
    public bool $isBlocked { get => TypeConverter::toBool($this->data['is_blocked'] ?? null, false) ?? false; }

    /** Note (nullable) */
    public ?string $note { get => isset($this->data['note']) ? TypeConverter::toString($this->data['note']) : null; }

    /** Product ID */
    public int $productId { get => TypeConverter::toInt($this->data['product_id'] ?? null, 0) ?? 0; }

    /**
     * @param array<string, mixed> $data Raw e-ticket record from the API
     */
    public function __construct(
        public readonly array $data,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return static
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        return new self($data);
    }
}
