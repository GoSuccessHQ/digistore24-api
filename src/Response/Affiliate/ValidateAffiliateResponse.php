<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Validate Affiliate Response
 *
 * Response object for validating affiliate credentials.
 */
final class ValidateAffiliateResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Whether the affiliate is valid
     */
    public bool $valid = false;

    /**
     * Affiliate ID
     */
    public ?int $affiliateId = null;

    /**
     * Affiliate code
     */
    public ?string $affiliateCode = null;

    /**
     * Whether the affiliate is active
     */
    public bool $isActive = false;

    /**
     * Affiliate email
     */
    public ?string $email = null;

    /**
     * Affiliate name
     */
    public ?string $name = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->valid = (bool)($innerData['valid'] ?? false);
        $response->affiliateId = TypeConverter::toInt($innerData['affiliate_id'] ?? null);
        $response->affiliateCode = is_string($innerData['affiliate_code'] ?? null) ? $innerData['affiliate_code'] : null;
        $response->isActive = (bool)($innerData['is_active'] ?? false);
        $response->email = is_string($innerData['email'] ?? null) ? $innerData['email'] : null;
        $response->name = is_string($innerData['name'] ?? null) ? $innerData['name'] : null;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
