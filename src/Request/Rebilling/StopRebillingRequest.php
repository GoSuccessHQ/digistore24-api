<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Stop Rebilling Request
 *
 * Stops automatic rebilling for a purchase or subscription.
 */
final class StopRebillingRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The unique identifier of the purchase
     */
    public function __construct(private string $purchaseId)
    {
    }

    public function getEndpoint(): string
    {
        return '/stopRebilling';
    }

    public function toArray(): array
    {
        return ['purchase_id' => $this->purchaseId];
    }
}
