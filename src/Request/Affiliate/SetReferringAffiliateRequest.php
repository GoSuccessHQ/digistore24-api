<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Set Referring Affiliate Request
 *
 * Assigns a referring partner (referrer) to an affiliate. The referrer earns a
 * share of the affiliate's commission.
 */
final class SetReferringAffiliateRequest extends AbstractRequest
{
    /**
     * @param string $referrerId The partner bringing affiliates
     * @param string $affiliateId The affiliate possibly referred by the partner
     * @param float|null $commission The percentage of the affiliate commission the vendor will pay to the referring partner
     */
    public function __construct(
        private string $referrerId,
        private string $affiliateId,
        private ?float $commission = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/setReferringAffiliate';
    }

    public function toArray(): array
    {
        $data = [
            'referrer_id' => $this->referrerId,
            'affiliate_id' => $this->affiliateId,
        ];

        if ($this->commission !== null) {
            $data['commission'] = $this->commission;
        }

        return $data;
    }
}
