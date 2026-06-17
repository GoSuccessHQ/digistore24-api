<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ConversionTool;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Validate Coupon Code Response
 *
 * Response object for the validateCouponCode endpoint.
 *
 * @link https://digistore24.com/api/docs/paths/validateCouponCode.yaml
 */
final class ValidateCouponCodeResponse extends AbstractResponse
{
    /**
     * Result status of the API call
     */
    public string $result = '';

    /**
     * Validation status (success or error)
     */
    public string $status = '';

    /**
     * Human-readable status message
     */
    public string $statusMsg = '';

    /**
     * Currency code of the voucher
     */
    public ?string $currency = null;

    /**
     * ID of the voucher
     */
    public ?int $couponId = null;

    /**
     * Remaining amount that can be used from this voucher
     */
    public ?float $amountLeft = null;

    /**
     * Total amount of the voucher
     */
    public ?float $amountTotal = null;

    /**
     * Whether the voucher can only be used for test payments
     */
    public ?bool $isTestPayment = null;

    /**
     * Check if the coupon is valid
     */
    public function isValid(): bool
    {
        return $this->status === 'success';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->status = TypeConverter::toString($innerData['status'] ?? null) ?? '';
        $response->statusMsg = TypeConverter::toString($innerData['status_msg'] ?? null) ?? '';
        $response->currency = TypeConverter::toString($innerData['currency'] ?? null);
        $response->couponId = TypeConverter::toInt($innerData['coupon_id'] ?? null);
        $response->amountLeft = TypeConverter::toFloat($innerData['amount_left'] ?? null);
        $response->amountTotal = TypeConverter::toFloat($innerData['amount_total'] ?? null);
        $response->isTestPayment = TypeConverter::toBool($innerData['is_test_payment'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
