<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Set Referring Affiliate Request
 *
 * Assigns a referring affiliate to a specific purchase.
 */
final class SetReferringAffiliateRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The purchase ID
     * @param string $affiliateId The affiliate ID to assign
     */
    public function __construct(
        private string $purchaseId,
        private string $affiliateId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/setReferringAffiliate';
    }

    public function toArray(): array
    {
        return [
            'purchase_id' => $this->purchaseId,
            'affiliate_id' => $this->affiliateId,
        ];
    }
}
