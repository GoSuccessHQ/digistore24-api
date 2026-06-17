<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Shipping Cost Policy List Item Data Transfer Object
 *
 * One entry returned by listShippingCostPolicies. These are response-only,
 * read-only fields and differ from the request fields in ShippingCostPolicyData.
 *
 * @link https://digistore24.com/api/docs/paths/listShippingCostPolicies.yaml
 */
final class ShippingCostPolicyListItemData extends AbstractDataTransferObject
{
    /**
     * Shipping cost policy ID
     */
    public ?int $id {
        get => $this->id;
    }

    /**
     * Policy name
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

    /**
     * Shipping cost rules
     *
     * @var array<int, mixed>
     */
    public array $rules {
        get => $this->rules;
    }

    /**
     * @param array<int, mixed> $rules
     */
    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $modifiedAt = null,
        array $rules = [],
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->rules = $rules;
    }
}
