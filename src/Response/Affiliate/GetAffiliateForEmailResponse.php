<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Affiliate For Email Response
 *
 * Response object for retrieving affiliate information by email.
 */
final class GetAffiliateForEmailResponse extends AbstractResponse
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
     * Affiliate email
     */
    public string $email = '';

    /**
     * First name
     */
    public ?string $firstName = null;

    /**
     * Last name
     */
    public ?string $lastName = null;

    /**
     * Affiliate code
     */
    public ?string $affiliateCode = null;

    /**
     * Whether affiliate is active
     */
    public bool $isActive = false;

    /**
     * Commission balance
     */
    public ?float $commissionBalance = null;

    /**
     * Total sales
     */
    public ?float $totalSales = null;

    /**
     * Account creation date
     */
    public ?\DateTimeInterface $createdAt = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->affiliateId = TypeConverter::toInt($innerData['affiliate_id'] ?? null);
        $response->email = is_string($innerData['email'] ?? null) ? $innerData['email'] : '';
        $response->firstName = is_string($innerData['first_name'] ?? null) ? $innerData['first_name'] : null;
        $response->lastName = is_string($innerData['last_name'] ?? null) ? $innerData['last_name'] : null;
        $response->affiliateCode = is_string($innerData['affiliate_code'] ?? null) ? $innerData['affiliate_code'] : null;
        $response->isActive = (bool)($innerData['is_active'] ?? false);
        $response->commissionBalance = TypeConverter::toFloat($innerData['commission_balance'] ?? null);
        $response->totalSales = TypeConverter::toFloat($innerData['total_sales'] ?? null);
        $response->createdAt = TypeConverter::toDateTime($innerData['created_at'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
