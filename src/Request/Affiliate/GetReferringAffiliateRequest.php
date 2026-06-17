<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Referring Affiliate Request
 *
 * Retrieves the referring partner (referrer) for a given affiliate.
 */
final class GetReferringAffiliateRequest extends AbstractRequest
{
    /**
     * @param string $affiliateId ID of the affiliate to check for a referral
     */
    public function __construct(
        private string $affiliateId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/getReferringAffiliate';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['affiliate_id' => $this->affiliateId];
    }
}
