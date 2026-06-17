<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Service Proof Request Data Transfer Object
 *
 * One service proof request as returned by getServiceProofRequest and as an
 * item of the listServiceProofRequests array. Read-only response fields; the
 * request-side update payload lives in ServiceProofRequestUpdateData.
 *
 * @link https://digistore24.com/api/docs/paths/getServiceProofRequest.yaml
 * @link https://digistore24.com/api/docs/paths/listServiceProofRequests.yaml
 */
final class ServiceProofRequestData extends AbstractDataTransferObject
{
    /** Service proof request ID */
    public ?int $id {
        get => $this->id;
    }

    /** Associated purchase ID */
    public ?string $purchaseId {
        get => $this->purchaseId;
    }

    /** Associated product ID (list responses) */
    public ?int $productId {
        get => $this->productId;
    }

    /** Delivery type (digital, shipping, service, event, download) */
    public ?string $deliveryType {
        get => $this->deliveryType;
    }

    /** Approval status (new, pending, approved, rejected) */
    public ?string $approvalStatus {
        get => $this->approvalStatus;
    }

    /** Request status (pending, proof_provided, exec_refund) */
    public ?string $requestStatus {
        get => $this->requestStatus;
    }

    /** Current status of the service proof request (detail responses) */
    public ?string $status {
        get => $this->status;
    }

    /** When the request was created */
    public ?DateTimeImmutable $createdAt {
        get => $this->createdAt;
    }

    /** When the request was last modified (list responses) */
    public ?DateTimeImmutable $modifiedAt {
        get => $this->modifiedAt;
    }

    /** When the proof needs to be provided by (detail responses) */
    public ?DateTimeImmutable $dueDate {
        get => $this->dueDate;
    }

    /** Additional notes about the request (detail responses) */
    public ?string $notes {
        get => $this->notes;
    }

    public function __construct(
        ?int $id = null,
        ?string $purchaseId = null,
        ?int $productId = null,
        ?string $deliveryType = null,
        ?string $approvalStatus = null,
        ?string $requestStatus = null,
        ?string $status = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $modifiedAt = null,
        ?DateTimeImmutable $dueDate = null,
        ?string $notes = null,
    ) {
        $this->id = $id;
        $this->purchaseId = $purchaseId;
        $this->productId = $productId;
        $this->deliveryType = $deliveryType;
        $this->approvalStatus = $approvalStatus;
        $this->requestStatus = $requestStatus;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->dueDate = $dueDate;
        $this->notes = $notes;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            id: TypeConverter::toInt($data['id'] ?? null),
            purchaseId: TypeConverter::toString($data['purchase_id'] ?? null),
            productId: TypeConverter::toInt($data['product_id'] ?? null),
            deliveryType: TypeConverter::toString($data['delivery_type'] ?? null),
            approvalStatus: TypeConverter::toString($data['approval_status'] ?? null),
            requestStatus: TypeConverter::toString($data['request_status'] ?? null),
            status: TypeConverter::toString($data['status'] ?? null),
            createdAt: TypeConverter::toDateTime($data['created_at'] ?? null),
            modifiedAt: TypeConverter::toDateTime($data['modified_at'] ?? null),
            dueDate: TypeConverter::toDateTime($data['due_date'] ?? null),
            notes: TypeConverter::toString($data['notes'] ?? null),
        );
    }
}
