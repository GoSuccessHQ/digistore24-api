<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Payment Plan List Item Data Transfer Object
 *
 * One entry returned by listPaymentPlans. These are response-only, read-only
 * fields and differ from the request fields in PaymentPlanFullData.
 *
 * @link https://digistore24.com/api/docs/paths/listPaymentPlans.yaml
 */
final class PaymentPlanListItemData extends AbstractDataTransferObject
{
    /**
     * Payment plan ID
     */
    public ?int $id {
        get => $this->id;
    }

    /**
     * Associated product ID
     */
    public ?int $productId {
        get => $this->productId;
    }

    /**
     * Payment plan name
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
        ?int $productId = null,
        ?string $name = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $modifiedAt = null,
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }
}
