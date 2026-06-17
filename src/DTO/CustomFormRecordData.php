<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Custom Form Record Data Transfer Object
 *
 * Represents a single custom form record collected during checkout, as
 * returned by listCustomFormRecords. The `data` and `address` maps hold the
 * dynamic key-value pairs entered by the buyer.
 *
 * @link https://digistore24.com/api/docs/paths/listCustomFormRecords.yaml
 */
final class CustomFormRecordData extends AbstractDataTransferObject
{
    /**
     * Form identifier
     */
    public ?int $formId {
        get => $this->formId ?? null;
    }

    /**
     * Record identifier
     */
    public ?int $id {
        get => $this->id ?? null;
    }

    /**
     * Digistore24 order ID the record belongs to
     */
    public ?string $purchaseId {
        get => $this->purchaseId ?? null;
    }

    /**
     * Purchase line item ID
     */
    public ?int $purchaseItemId {
        get => $this->purchaseItemId ?? null;
    }

    /**
     * Product identifier
     */
    public ?int $productId {
        get => $this->productId ?? null;
    }

    /**
     * Form sequence number
     */
    public ?int $formNo {
        get => $this->formNo ?? null;
    }

    /**
     * Total number of forms in the set
     */
    public ?int $formCount {
        get => $this->formCount ?? null;
    }

    /**
     * All entered data as key-value pairs
     *
     * @var array<string, string>
     */
    public array $data = [] {
        get => $this->data;
    }

    /**
     * Address-related data as key-value pairs
     *
     * @var array<string, string>
     */
    public array $address = [] {
        get => $this->address;
    }

    /**
     * Build a record from the API's snake_case payload.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $record = parent::fromArray($data);

        $record->data = self::toStringMap($data['data'] ?? null);
        $record->address = self::toStringMap($data['address'] ?? null);

        return $record;
    }

    /**
     * @return array<string, string>
     */
    private static function toStringMap(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = is_scalar($item) ? (string)$item : '';
        }

        return $result;
    }
}
