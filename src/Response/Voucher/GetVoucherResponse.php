<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Voucher;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\VoucherData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Voucher Response
 *
 * Response object for the getVoucher API endpoint.
 * Returns detailed information about a voucher/coupon.
 */
final class GetVoucherResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * The voucher data
     */
    public ?VoucherData $voucher = null;

    /**
     * The complete voucher payload as returned by the API, so every field is
     * accessible even when not surfaced on the VoucherData object above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * Create response from API data
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $instance = new self();
        $instance->result = self::extractResult(data: $data, rawResponse: $rawResponse);

        if ($rawResponse !== null) {
            $instance->rawResponse = $rawResponse;
        }

        // OpenAPI spec shows voucher data is in 'data' -> 'coupon'
        $innerData = self::extractInnerData(data: $data);
        $voucherData = is_array($innerData['coupon'] ?? null) ? $innerData['coupon'] : [];

        /** @var array<string, mixed> $validatedVoucherData */
        $validatedVoucherData = $voucherData;
        $instance->voucher = VoucherData::fromArray(data: $validatedVoucherData);
        $instance->data = $validatedVoucherData;

        return $instance;
    }
}
