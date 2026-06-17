<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Voucher;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Voucher Request
 *
 * Retrieves voucher details by code or ID.
 */
final class GetVoucherRequest extends AbstractRequest
{
    /**
     * @param string $code The voucher code or ID
     */
    public function __construct(
        private string $code,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/getVoucher';
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
