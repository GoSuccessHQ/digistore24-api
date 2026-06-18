<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Voucher;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\VoucherData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Update Voucher Request
 *
 * Updates an existing voucher's configuration.
 */
final class UpdateVoucherRequest extends AbstractRequest
{
    /**
     * @param string $code The voucher code
     * @param VoucherData $voucher Updated voucher data
     */
    public function __construct(
        private string $code,
        private VoucherData $voucher,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/updateVoucher';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        // code stays flat (query param); the fields go under data[] -- sent flat
        // the update is silently ignored (modified:N). Verified live.
        return ['code' => $this->code, 'data' => $this->voucher->toArray()];
    }
}
