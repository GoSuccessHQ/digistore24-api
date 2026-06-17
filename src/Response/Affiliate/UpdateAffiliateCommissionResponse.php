<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Update Affiliate Commission Response
 *
 * Response object for updating affiliate commission settings.
 */
final class UpdateAffiliateCommissionResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Product ID
     */
    public int $productId = 0;

    /**
     * Commission rate (percentage)
     */
    public ?float $commissionRate = null;

    /**
     * First level commission rate
     */
    public ?float $firstLevelCommission = null;

    /**
     * Second level commission rate
     */
    public ?float $secondLevelCommission = null;

    /**
     * Whether affiliate program is enabled
     */
    public bool $isAffiliateEnabled = false;

    /**
     * Update timestamp
     */
    public ?\DateTimeInterface $updatedAt = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->productId = TypeConverter::toInt($innerData['product_id'] ?? null) ?? 0;
        $response->commissionRate = TypeConverter::toFloat($innerData['commission_rate'] ?? null);
        $response->firstLevelCommission = TypeConverter::toFloat($innerData['first_level_commission'] ?? null);
        $response->secondLevelCommission = TypeConverter::toFloat($innerData['second_level_commission'] ?? null);
        $response->isAffiliateEnabled = (bool)($innerData['is_affiliate_enabled'] ?? false);
        $response->updatedAt = TypeConverter::toDateTime($innerData['updated_at'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
