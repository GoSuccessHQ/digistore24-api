<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Start Rebilling Request
 *
 * Starts or resumes automatic rebilling for a purchase.
 */
final class StartRebillingRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The unique identifier of the purchase
     */
    public function __construct(private string $purchaseId)
    {
    }

    public function getEndpoint(): string
    {
        return '/startRebilling';
    }

    public function toArray(): array
    {
        return ['purchase_id' => $this->purchaseId];
    }
}
