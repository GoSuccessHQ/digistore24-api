<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Purchase Tracking Info Data
 *
 * The `data` object returned by getPurchaseTracking for a single order. Holds
 * the tracking data (UTM parameters, click ID, sub IDs and tracking keys).
 * Response-only DTO: all fields use get-only property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getPurchaseTracking.yaml
 */
final class PurchaseTrackingInfoData extends AbstractDataTransferObject
{
    /**
     * UTM tracking parameters
     */
    public ?UtmParamsData $utmParams = null {
        get => $this->utmParams;
    }

    /**
     * Click tracking ID
     */
    public ?string $clickId = null {
        get => $this->clickId;
    }

    /**
     * Sub IDs
     *
     * @var array<int, string>
     */
    public array $subIds = [] {
        get => $this->subIds;
    }

    /**
     * Vendor tracking key
     */
    public ?string $vendorKey = null {
        get => $this->vendorKey;
    }

    /**
     * Campaign tracking key
     */
    public ?string $campaignKey = null {
        get => $this->campaignKey;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        $instance = parent::fromArray($data);

        // Normalize sub_ids to a list of strings (the auto-converter leaves it raw).
        $rawSubIds = $data['sub_ids'] ?? $data['subIds'] ?? [];
        if (is_array($rawSubIds)) {
            $subIds = [];
            foreach ($rawSubIds as $subId) {
                if (is_scalar($subId)) {
                    $subIds[] = (string)$subId;
                }
            }
            $reflection = new \ReflectionProperty($instance, 'subIds');
            $reflection->setRawValue($instance, $subIds);
        }

        return $instance;
    }
}
