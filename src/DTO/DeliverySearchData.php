<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeInterface;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Delivery Search Criteria Data
 *
 * Search filter for the listDeliveries `search` object.
 *
 * @link https://digistore24.com/api/docs/paths/listDeliveries.yaml
 */
final class DeliverySearchData extends AbstractDataTransferObject
{
    /**
     * @param string|null $purchaseId Filter by order/purchase ID
     * @param DateTimeInterface|null $from Start date for filtering
     * @param DateTimeInterface|null $to End date for filtering
     * @param string|null $type Comma-separated list of delivery types (request, in_progress, delivery, partial_delivery, return, cancel)
     * @param string|null $sameAddressAs Lists all deliveries shipped to the same address as the given delivery_id
     * @param bool|null $isProcessed Filter by processed status
     * @param bool|null $isTestOrder Filter test (true) vs real (false) orders
     */
    public function __construct(
        public ?string $purchaseId = null,
        public ?DateTimeInterface $from = null,
        public ?DateTimeInterface $to = null,
        public ?string $type = null,
        public ?string $sameAddressAs = null,
        public ?bool $isProcessed = null,
        public ?bool $isTestOrder = null,
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
        if ($this->from !== null) {
            $data['from'] = $this->from->format('Y-m-d');
        }
        if ($this->to !== null) {
            $data['to'] = $this->to->format('Y-m-d');
        }
        if ($this->type !== null) {
            $data['type'] = $this->type;
        }
        if ($this->sameAddressAs !== null) {
            $data['same_address_as'] = $this->sameAddressAs;
        }
        if ($this->isProcessed !== null) {
            $data['is_processed'] = $this->isProcessed;
        }
        if ($this->isTestOrder !== null) {
            $data['is_test_order'] = TypeConverter::fromBool($this->isTestOrder);
        }

        return $data;
    }
}
