<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Product Group List Item Data Transfer Object
 *
 * One entry returned by listProductGroups. These are response-only, read-only
 * fields and differ from the request fields in ProductGroupData.
 *
 * @link https://digistore24.com/api/docs/paths/listProductGroups.yaml
 */
final class ProductGroupListItemData extends AbstractDataTransferObject
{
    /**
     * Product group ID
     */
    public ?int $id {
        get => $this->id;
    }

    /**
     * Product group name
     */
    public ?string $name {
        get => $this->name;
    }

    /**
     * Creation timestamp
     */
    public ?DateTimeImmutable $createdAt {
        get => $this->createdAt;
    }

    /**
     * Last modification timestamp
     */
    public ?DateTimeImmutable $modifiedAt {
        get => $this->modifiedAt;
    }

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $modifiedAt = null,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }
}
