<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\AffiliateCommissionData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Update Affiliate Commission Request
 *
 * Updates commission settings for a specific affiliate and product.
 */
final class UpdateAffiliateCommissionRequest extends AbstractRequest
{
    /**
     * @param string $affiliateId The ID or the name of the affiliate
     * @param string $productIds Comma-separated list of product IDs for which the commission should be changed, or "all" for all products
     * @param AffiliateCommissionData $commission Commission settings data
     */
    public function __construct(
        private string $affiliateId,
        private string $productIds,
        private AffiliateCommissionData $commission,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/updateAffiliateCommission';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        return array_merge(
            [
                'affiliate_id' => $this->affiliateId,
                'product_ids' => $this->productIds,
            ],
            $this->commission->toArray(),
        );
    }
}
