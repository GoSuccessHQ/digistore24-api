<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Request to add balance to a purchase
 *
 * @link https://digistore24.com/api/docs/paths/addBalanceToPurchase.yaml OpenAPI Specification
 */
final class AddBalanceToPurchaseRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The Digistore24 order ID
     * @param float $amount The balance to be added (negative values reduce balance, but total cannot go below 0)
     */
    public function __construct(
        public string $purchaseId,
        public float $amount,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/addBalanceToPurchase';
    }
}
