<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanFullData;

/**
 * Create Payment Plan Request
 *
 * Creates a new payment plan with installment configuration.
 */
final class CreatePaymentplanRequest extends AbstractRequest
{
    /**
     * @param int $productId The product the payment plan belongs to
     * @param PaymentPlanFullData $paymentPlan The payment plan configuration
     */
    public function __construct(private int $productId, private PaymentPlanFullData $paymentPlan)
    {
    }

    public function getEndpoint(): string
    {
        return '/createPaymentplan';
    }

    public function toArray(): array
    {
        return ['product_id' => $this->productId, 'data' => $this->paymentPlan->toArray()];
    }
}
