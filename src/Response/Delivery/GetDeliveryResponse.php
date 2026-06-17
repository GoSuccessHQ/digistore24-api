<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Delivery;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\DeliveryDetailsData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Delivery Response
 *
 * Response object for the Delivery API endpoint.
 */
final class GetDeliveryResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Delivery details
     */
    public ?DeliveryDetailsData $delivery = null;

    /**
     * Whether delivery was marked as in progress
     */
    public bool $isSetInProgress = false;

    /**
     * Reason why setting in progress failed, if applicable
     */
    public ?string $setInProgressFailReason = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $deliveryData = $innerData['delivery'] ?? [];
        if (! is_array($deliveryData)) {
            $deliveryData = [];
        }

        /** @var array<string, mixed> $validDeliveryData */
        $validDeliveryData = $deliveryData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->delivery = empty($validDeliveryData) ? null : DeliveryDetailsData::fromArray($validDeliveryData);
        $response->isSetInProgress = TypeConverter::toBool($innerData['is_set_in_progress'] ?? null) ?? false;
        $response->setInProgressFailReason = TypeConverter::toString($innerData['set_in_progress_fail_reason'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
