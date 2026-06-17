<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Enum\RebillingStatusChangeType;

/**
 * Rebilling Status Change Data Transfer Object
 *
 * Represents a single rebilling status change returned in data.items[] by
 * listRebillingStatusChanges. Response-only: all properties expose get hooks.
 *
 * @link https://digistore24.com/api/docs/paths/listRebillingStatusChanges.yaml
 */
final class RebillingStatusChangeData extends AbstractDataTransferObject
{
    /**
     * Status change identifier.
     */
    public ?int $id = null {
        get => $this->id;
    }

    /**
     * Associated purchase identifier.
     */
    public ?string $purchaseId = null {
        get => $this->purchaseId;
    }

    /**
     * Timestamp when the change occurred.
     */
    public ?DateTimeImmutable $createdAt = null {
        get => $this->createdAt;
    }

    /**
     * Payment sequence number.
     */
    public ?int $paySequenceNo = null {
        get => $this->paySequenceNo;
    }

    /**
     * Type of the status change.
     */
    public ?RebillingStatusChangeType $type = null {
        get => $this->type;
    }

    /**
     * Human-readable status change message.
     */
    public ?string $typeMsg = null {
        get => $this->typeMsg;
    }
}
