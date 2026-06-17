<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Refund Partially Request
 *
 * Processes a partial refund for a purchase with a specified amount.
 */
final class RefundPartiallyRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The purchase ID to refund
     * @param float $amount The amount to refund (must not exceed the payment amount)
     */
    public function __construct(
        private string $purchaseId,
        private float $amount,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/refundPartially';
    }

    public function toArray(): array
    {
        return [
            'purchase_id' => $this->purchaseId,
            'amount' => $this->amount,
        ];
    }
}
