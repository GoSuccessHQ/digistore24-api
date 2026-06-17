<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Enum\BillingPaymentStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Rebilling Payment Response
 *
 * Response for createRebillingPayment, reporting the outcome of the manually
 * triggered rebilling charge.
 *
 * @link https://digistore24.com/api/docs/paths/createRebillingPayment.yaml
 */
final class CreateRebillingPaymentResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The order ID (same as the input parameter).
     */
    public ?string $purchaseId = null;

    /**
     * Status of the payment attempt (completed, pending, uncertain, refused, error).
     */
    public ?BillingPaymentStatus $paymentStatus = null;

    /**
     * Error message in case of payment failure.
     */
    public ?string $paymentMessage = null;

    /**
     * Current state of the billing cycle (paying, aborted, unpaid, completed,
     * payment_data_update_required).
     */
    public ?string $billingStatus = null;

    /**
     * URL where the buyer can update their payment information.
     */
    public ?string $paymentDataUpdateUrl = null;

    /**
     * The complete inner payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->purchaseId = TypeConverter::toString($validatedData['purchase_id'] ?? null);
        $response->paymentStatus = BillingPaymentStatus::fromString(
            TypeConverter::toString($validatedData['payment_status'] ?? null),
        );
        $response->paymentMessage = TypeConverter::toString($validatedData['payment_message'] ?? null);
        $response->billingStatus = TypeConverter::toString($validatedData['billing_status'] ?? null);
        $response->paymentDataUpdateUrl = TypeConverter::toString($validatedData['payment_data_update_url'] ?? null);
        $response->data = $validatedData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
