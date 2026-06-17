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
     * @param string $purchaseId The unique identifier of the purchase
     * @param float $amount The refund amount
     * @param string $reason Optional reason for the partial refund
     */
    public function __construct(private string $purchaseId, private float $amount, private string $reason = '')
    {
    }

    public function getEndpoint(): string
    {
        return '/refundPartially';
    }

    public function toArray(): array
    {
        $params = ['purchase_id' => $this->purchaseId, 'amount' => $this->amount];
        if ($this->reason !== '') {
            $params['reason'] = $this->reason;
        }

        return $params;
    }
}
