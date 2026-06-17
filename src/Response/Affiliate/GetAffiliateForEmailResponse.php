<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Affiliate For Email Response
 *
 * Response object for retrieving the affiliate that is assigned to a buyer email.
 *
 * @link https://digistore24.com/api/docs/paths/getAffiliateForEmail.yaml
 */
final class GetAffiliateForEmailResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Name of the affiliate
     */
    public ?string $affiliateName = null;

    /**
     * Unique ID of the affiliate
     */
    public ?int $affiliateId = null;

    /**
     * Campaign key
     */
    public ?string $campaignkey = null;

    /**
     * Tracking key
     */
    public ?string $trackingkey = null;

    /**
     * Click ID
     */
    public ?string $clickId = null;

    /**
     * Timestamp of the promotional click
     */
    public ?\DateTimeInterface $promoclickAt = null;

    /**
     * The complete affiliate payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->affiliateName = TypeConverter::toString($innerData['affiliate_name'] ?? null);
        $response->affiliateId = TypeConverter::toInt($innerData['affiliate_id'] ?? null);
        $response->campaignkey = TypeConverter::toString($innerData['campaignkey'] ?? null);
        $response->trackingkey = TypeConverter::toString($innerData['trackingkey'] ?? null);
        $response->clickId = TypeConverter::toString($innerData['click_id'] ?? null);
        $response->promoclickAt = TypeConverter::toDateTime($innerData['promoclick_at'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
