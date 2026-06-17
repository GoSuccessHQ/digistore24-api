<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Voucher;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Delete Voucher Request
 *
 * Deletes a voucher by its code.
 */
final class DeleteVoucherRequest extends AbstractRequest
{
    /**
     * @param string $code The voucher code to delete
     */
    public function __construct(
        private string $code,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/deleteVoucher';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function toArray(): array
    {
        return ['code' => $this->code];
    }
}
