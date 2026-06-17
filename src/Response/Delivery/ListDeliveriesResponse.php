<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Delivery;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\DeliveryDetailsData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Deliveries Response
 *
 * Response containing a list of deliveries. Each entry exposes the full set of
 * spec delivery fields (including delivery_address and tracking) as a typed DTO.
 *
 * @link https://digistore24.com/api/docs/paths/listDeliveries.yaml
 */
final class ListDeliveriesResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * @var array<int, DeliveryDetailsData>
     */
    public array $deliveries = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $deliveriesData = $innerData['deliveries'] ?? [];

        $deliveries = [];
        if (is_array($deliveriesData)) {
            foreach ($deliveriesData as $deliveryItem) {
                if (! is_array($deliveryItem)) {
                    continue;
                }
                /** @var array<string, mixed> $validDeliveryItem */
                $validDeliveryItem = $deliveryItem;
                $deliveries[] = DeliveryDetailsData::fromArray($validDeliveryItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->deliveries = $deliveries;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
