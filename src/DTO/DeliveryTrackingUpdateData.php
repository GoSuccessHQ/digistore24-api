<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeInterface;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Enum\DeliveryTrackingOperation;

/**
 * Delivery Tracking Update Data Transfer Object
 *
 * One tracking entry sent to the updateDelivery endpoint. These are the request
 * fields (parcel_service, tracking_id, expect_delivery_at, quantity, operation),
 * which differ from the read-only DeliveryTrackingData returned by getDelivery.
 *
 * @link https://digistore24.com/api/docs/paths/updateDelivery.yaml
 */
final class DeliveryTrackingUpdateData extends AbstractDataTransferObject
{
    /**
     * @param string|null $parcelService The parcel service key (see https://www.digistore24.com/support/parcel_services)
     * @param string|null $trackingId The tracking ID for the shipment
     * @param DateTimeInterface|null $expectDeliveryAt Expected delivery date
     * @param int|null $quantity Quantity of items in this tracking entry (defaults to all items)
     * @param DeliveryTrackingOperation $operation Operation to perform on the tracking information
     */
    public function __construct(
        public ?string $parcelService = null,
        public ?string $trackingId = null,
        public ?DateTimeInterface $expectDeliveryAt = null,
        public ?int $quantity = null,
        public DeliveryTrackingOperation $operation = DeliveryTrackingOperation::CREATE_OR_UPDATE,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = ['operation' => $this->operation->value];

        if ($this->parcelService !== null) {
            $data['parcel_service'] = $this->parcelService;
        }
        if ($this->trackingId !== null) {
            $data['tracking_id'] = $this->trackingId;
        }
        if ($this->expectDeliveryAt !== null) {
            $data['expect_delivery_at'] = $this->expectDeliveryAt->format('Y-m-d');
        }
        if ($this->quantity !== null) {
            $data['quantity'] = $this->quantity;
        }

        return $data;
    }
}
