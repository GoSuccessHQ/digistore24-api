<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Set Referring Affiliate Response
 *
 * Response object for setting referring affiliate for a customer.
 */
final class SetReferringAffiliateResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Customer email
     */
    public string $email = '';

    /**
     * Affiliate ID
     */
    public ?int $affiliateId = null;

    /**
     * Affiliate code
     */
    public ?string $affiliateCode = null;

    /**
     * Timestamp when affiliate was set
     */
    public ?\DateTimeInterface $setAt = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->email = is_string($innerData['email'] ?? null) ? $innerData['email'] : '';
        $response->affiliateId = TypeConverter::toInt($innerData['affiliate_id'] ?? null);
        $response->affiliateCode = is_string($innerData['affiliate_code'] ?? null) ? $innerData['affiliate_code'] : null;
        $response->setAt = TypeConverter::toDateTime($innerData['set_at'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
