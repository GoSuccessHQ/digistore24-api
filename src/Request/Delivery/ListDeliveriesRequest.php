<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Delivery;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\DeliverySearchData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Deliveries Request
 *
 * Retrieves a list of deliveries, optionally filtered by a search object
 * (purchase_id, from, to, type, same_address_as, is_processed, is_test_order).
 *
 * @link https://digistore24.com/api/docs/paths/listDeliveries.yaml
 */
final class ListDeliveriesRequest extends AbstractRequest
{
    /**
     * @param DeliverySearchData|null $search Optional search criteria
     */
    public function __construct(
        private ?DeliverySearchData $search = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listDeliveries';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $params = [];

        if ($this->search !== null) {
            $searchParams = $this->search->toArray();
            if ($searchParams !== []) {
                $params['search'] = $searchParams;
            }
        }

        return $params;
    }
}
