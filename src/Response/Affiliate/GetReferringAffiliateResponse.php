<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Referring Affiliate Response
 *
 * Response object for retrieving referring affiliate information.
 */
final class GetReferringAffiliateResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Affiliate ID
     */
    public ?int $affiliateId = null;

    /**
     * Affiliate code
     */
    public ?string $affiliateCode = null;

    /**
     * Affiliate email
     */
    public ?string $affiliateEmail = null;

    /**
     * Affiliate name
     */
    public ?string $affiliateName = null;

    /**
     * Referral date
     */
    public ?\DateTimeInterface $referralDate = null;

    /**
     * Commission earned
     */
    public ?float $commissionEarned = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->affiliateId = TypeConverter::toInt($innerData['affiliate_id'] ?? null);
        $response->affiliateCode = is_string($innerData['affiliate_code'] ?? null) ? $innerData['affiliate_code'] : null;
        $response->affiliateEmail = is_string($innerData['affiliate_email'] ?? null) ? $innerData['affiliate_email'] : null;
        $response->affiliateName = is_string($innerData['affiliate_name'] ?? null) ? $innerData['affiliate_name'] : null;
        $response->referralDate = TypeConverter::toDateTime($innerData['referral_date'] ?? null);
        $response->commissionEarned = TypeConverter::toFloat($innerData['commission_earned'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
