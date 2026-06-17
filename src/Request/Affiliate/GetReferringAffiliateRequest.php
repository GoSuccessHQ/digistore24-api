<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Referring Affiliate Request
 *
 * Retrieves the referring affiliate for a specific purchase.
 */
final class GetReferringAffiliateRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The purchase ID
     */
    public function __construct(
        private string $purchaseId,
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
        return ['purchase_id' => $this->purchaseId];
    }
}
