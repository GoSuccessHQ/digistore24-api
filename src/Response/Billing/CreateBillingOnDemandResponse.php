<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Billing;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Response from creating a billing on demand order.
 *
 * Contains information about the created order including purchase ID,
 * payment status, and billing status.
 *
 * @see https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml
 */
final class CreateBillingOnDemandResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * The ID of the newly created order
     */
    public string $createdPurchaseId = '';

    /**
     * Payment status code
     */
    public string $paymentStatus = '';

    /**
     * Payment status in readable form
     */
    public string $paymentStatusMsg = '';

    /**
     * Billing status code
     */
    public string $billingStatus = '';

    /**
     * Billing status in readable form
     */
    public string $billingStatusMsg = '';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->createdPurchaseId = is_string($innerData['created_purchase_id'] ?? null) ? $innerData['created_purchase_id'] : '';
        $response->paymentStatus = is_string($innerData['payment_status'] ?? null) ? $innerData['payment_status'] : '';
        $response->paymentStatusMsg = is_string($innerData['payment_status_msg'] ?? null) ? $innerData['payment_status_msg'] : '';
        $response->billingStatus = is_string($innerData['billing_status'] ?? null) ? $innerData['billing_status'] : '';
        $response->billingStatusMsg = is_string($innerData['billing_status_msg'] ?? null) ? $innerData['billing_status_msg'] : '';

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
