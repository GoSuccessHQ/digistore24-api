<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Delete Payment Plan Request
 *
 * Deletes an existing payment plan by its unique identifier.
 */
final class DeletePaymentplanRequest extends AbstractRequest
{
    /**
     * @param string $paymentplanId The unique identifier of the payment plan to delete
     */
    public function __construct(private string $paymentplanId)
    {
    }

    public function getEndpoint(): string
    {
        return '/deletePaymentplan';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function toArray(): array
    {
        return ['paymentplan_id' => $this->paymentplanId];
    }
}
