<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create Addon Change Purchase Response
 *
 * Response after creating a package change order.
 */
final class CreateAddonChangePurchaseResponse extends AbstractResponse
{
    public string $result = '';

    /** The ID of the new order */
    public string $createdPurchaseId = '';

    /** The payment status */
    public string $paymentStatus = '';

    /** Payment status in readable form */
    public string $paymentStatusMsg = '';

    /** Status of the new order */
    public string $billingStatus = '';

    /** Order status in readable form */
    public string $billingStatusMsg = '';

    /** URL to restart payments if payment failed */
    public ?string $payUrl = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $createdPurchaseId = self::getValue(data: $data, key: 'created_purchase_id', type: 'string', default: '');
        $paymentStatus = self::getValue(data: $data, key: 'payment_status', type: 'string', default: '');
        $paymentStatusMsg = self::getValue(data: $data, key: 'payment_status_msg', type: 'string', default: '');
        $billingStatus = self::getValue(data: $data, key: 'billing_status', type: 'string', default: '');
        $billingStatusMsg = self::getValue(data: $data, key: 'billing_status_msg', type: 'string', default: '');
        $payUrl = self::getValue(data: $data, key: 'pay_url', type: 'string', default: null);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->createdPurchaseId = is_string($createdPurchaseId) ? $createdPurchaseId : '';
        $response->paymentStatus = is_string($paymentStatus) ? $paymentStatus : '';
        $response->paymentStatusMsg = is_string($paymentStatusMsg) ? $paymentStatusMsg : '';
        $response->billingStatus = is_string($billingStatus) ? $billingStatus : '';
        $response->billingStatusMsg = is_string($billingStatusMsg) ? $billingStatusMsg : '';
        $response->payUrl = $payUrl !== null && is_string($payUrl) ? $payUrl : null;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
