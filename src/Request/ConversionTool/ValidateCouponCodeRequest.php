<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ConversionTool;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Validate Coupon Code Request
 *
 * Validates a coupon or voucher code and returns its details.
 */
final class ValidateCouponCodeRequest extends AbstractRequest
{
    /**
     * @param string $code The coupon/voucher code to validate
     */
    public function __construct(
        private string $code,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/validateCouponCode';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['code' => $this->code];
    }
}
