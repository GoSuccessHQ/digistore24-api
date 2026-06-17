<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Order Form List Item Data Transfer Object
 *
 * One entry returned by listOrderforms. These are response-only, read-only
 * fields and differ from the request fields in OrderFormData.
 *
 * @link https://digistore24.com/api/docs/paths/listOrderforms.yaml
 */
final class OrderformListItemData extends AbstractDataTransferObject
{
    /**
     * Order form ID
     */
    public ?int $id {
        get => $this->id;
    }

    /**
     * Order form name
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
