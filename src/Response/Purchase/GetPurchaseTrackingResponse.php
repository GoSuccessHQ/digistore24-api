<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\PurchaseTrackingInfoData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Purchase Tracking Response
 *
 * Response containing tracking data for the queried order(s). For a single order
 * the API returns one `data` object; for multiple comma-separated order IDs it
 * returns a map of purchase ID => tracking data.
 *
 * @link https://digistore24.com/api/docs/paths/getPurchaseTracking.yaml
 */
final class GetPurchaseTrackingResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Typed tracking data for the (first/only) order.
     */
    public ?PurchaseTrackingInfoData $tracking = null;

    /**
     * Typed tracking data keyed by purchase ID when multiple order IDs are queried.
     *
     * @var array<string, PurchaseTrackingInfoData>
     */
    public array $trackingByPurchase = [];

    /**
     * The complete payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData($data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $innerData;

        if (self::looksLikeTracking($innerData)) {
            $response->tracking = PurchaseTrackingInfoData::fromArray($innerData);
        } else {
            foreach ($innerData as $key => $value) {
                if (! is_array($value)) {
                    continue;
                }
                /** @var array<string, mixed> $entry */
                $entry = self::toStringKeyedArray($value);
                $response->trackingByPurchase[(string)$key] = PurchaseTrackingInfoData::fromArray($entry);
            }

            $first = $response->trackingByPurchase[array_key_first($response->trackingByPurchase) ?? ''] ?? null;
            $response->tracking = $first;
        }

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @param array<string, mixed> $data
     */
    private static function looksLikeTracking(array $data): bool
    {
        return array_key_exists('utm_params', $data)
            || array_key_exists('click_id', $data)
            || array_key_exists('sub_ids', $data)
            || array_key_exists('vendor_key', $data)
            || array_key_exists('campaign_key', $data);
    }

    /**
     * @param array<mixed, mixed> $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(array $value): array
    {
        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
