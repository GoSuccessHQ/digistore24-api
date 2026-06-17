<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanFullData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Update Payment Plan Request
 *
 * Updates an existing payment plan's configuration.
 */
final class UpdatePaymentplanRequest extends AbstractRequest
{
    /**
     * @param string $paymentplanId The unique identifier of the payment plan to update
     * @param PaymentPlanFullData $paymentPlan The updated payment plan configuration
     */
    public function __construct(private string $paymentplanId, private PaymentPlanFullData $paymentPlan)
    {
    }

    public function getEndpoint(): string
    {
        return '/updatePaymentplan';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        return array_merge(['paymentplan_id' => $this->paymentplanId], $this->paymentPlan->toArray());
    }
}
