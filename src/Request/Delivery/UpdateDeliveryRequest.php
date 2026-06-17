<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Delivery;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\DeliveryData;
use GoSuccess\Digistore24\Api\DTO\DeliveryTrackingUpdateData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Update Delivery Request
 *
 * Updates a delivery record with a new status, tracking information, and other
 * details. The status fields are sent inside a `data` object and shipment tracking
 * entries inside a separate `tracking` array, as defined by the spec.
 *
 * @link https://digistore24.com/api/docs/paths/updateDelivery.yaml
 */
final class UpdateDeliveryRequest extends AbstractRequest
{
    /**
     * @param string $deliveryId The ID of the delivery to update
     * @param DeliveryData $delivery Delivery status data (sent as the `data` object)
     * @param list<DeliveryTrackingUpdateData> $tracking Tracking entries to create, update, or delete
     * @param bool $notifyViaEmail Whether to notify the buyer about the delivery update
     */
    public function __construct(
        private string $deliveryId,
        private DeliveryData $delivery,
        private array $tracking = [],
        private bool $notifyViaEmail = true,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/updateDelivery';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        $params = [
            'delivery_id' => $this->deliveryId,
            'notify_via_email' => TypeConverter::fromBool($this->notifyViaEmail),
            'data' => $this->delivery->toArray(),
        ];

        if ($this->tracking !== []) {
            $params['tracking'] = array_map(
                static fn (DeliveryTrackingUpdateData $entry): array => $entry->toArray(),
                $this->tracking,
            );
        }

        return $params;
    }
}
