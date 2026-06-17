<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Referring Affiliate Response
 *
 * Response object describing the referring partner (referrer) of an affiliate.
 *
 * @link https://digistore24.com/api/docs/paths/getReferringAffiliate.yaml
 */
final class GetReferringAffiliateResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * ID of the referred affiliate
     */
    public ?int $affiliateId = null;

    /**
     * Username of the referred affiliate
     */
    public ?string $affiliateName = null;

    /**
     * ID of the referring partner
     */
    public ?int $referrerId = null;

    /**
     * Username of the referring partner
     */
    public ?string $referrerName = null;

    /**
     * Commission percentage
     */
    public ?float $commission = null;

    /**
     * When the referral was created
     */
    public ?\DateTimeInterface $createdAt = null;

    /**
     * ID of the user who created the referral
     */
    public ?int $createdBy = null;

    /**
     * The complete referral payload as returned by the API, so every field is
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
        $response->affiliateId = TypeConverter::toInt($innerData['affiliate_id'] ?? null);
        $response->affiliateName = TypeConverter::toString($innerData['affiliate_name'] ?? null);
        $response->referrerId = TypeConverter::toInt($innerData['referrer_id'] ?? null);
        $response->referrerName = TypeConverter::toString($innerData['referrer_name'] ?? null);
        $response->commission = TypeConverter::toFloat($innerData['commission'] ?? null);
        $response->createdAt = TypeConverter::toDateTime($innerData['created_at'] ?? null);
        $response->createdBy = TypeConverter::toInt($innerData['created_by'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
