<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Enum\DeliveryType;
use GoSuccess\Digistore24\Api\Enum\ServiceProofApprovalStatus;
use GoSuccess\Digistore24\Api\Enum\ServiceProofRequestStatus;

/**
 * Service Proof Request Search Criteria Data
 *
 * Search filter for the listServiceProofRequests `search` object.
 *
 * @link https://digistore24.com/api/docs/paths/listServiceProofRequests.yaml
 */
final class ServiceProofRequestSearchData extends AbstractDataTransferObject
{
    /**
     * @param string|null $purchaseId Filter by purchase ID
     * @param int|null $productId Filter by product ID
     * @param DeliveryType|null $deliveryType Filter by delivery type
     * @param ServiceProofApprovalStatus|null $approvalStatus Filter by approval status
     * @param ServiceProofRequestStatus|null $requestStatus Filter by request status
     */
    public function __construct(
        public ?string $purchaseId = null,
        public ?int $productId = null,
        public ?DeliveryType $deliveryType = null,
        public ?ServiceProofApprovalStatus $approvalStatus = null,
        public ?ServiceProofRequestStatus $requestStatus = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->purchaseId !== null) {
            $data['purchase_id'] = $this->purchaseId;
        }
        if ($this->productId !== null) {
            $data['product_id'] = $this->productId;
        }
        if ($this->deliveryType !== null) {
            $data['delivery_type'] = $this->deliveryType->value;
        }
        if ($this->approvalStatus !== null) {
            $data['approval_status'] = $this->approvalStatus->value;
        }
        if ($this->requestStatus !== null) {
            $data['request_status'] = $this->requestStatus->value;
        }

        return $data;
    }
}
