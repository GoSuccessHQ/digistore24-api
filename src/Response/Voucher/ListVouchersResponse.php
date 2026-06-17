<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Voucher;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\VoucherData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Vouchers Response
 *
 * Response object for the listVouchers API endpoint.
 * Returns a list of all vouchers/coupons.
 */
final class ListVouchersResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * List of vouchers
     *
     * @var array<int, VoucherData>
     */
    public array $coupons = [];

    /**
     * Whether returned data is public
     */
    public bool $areReturnedDataPublic = false;

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

        $innerData = self::extractInnerData(data: $data);
        $couponsData = is_array($innerData['coupons'] ?? null) ? $innerData['coupons'] : [];

        $coupons = [];
        foreach ($couponsData as $couponData) {
            if (is_array($couponData)) {
                /** @var array<string, mixed> $validCouponData */
                $validCouponData = $couponData;
                $coupons[] = VoucherData::fromArray(data: $validCouponData);
            }
        }
        $instance->coupons = $coupons;

        $instance->areReturnedDataPublic = TypeConverter::toBool(value: $innerData['are_returned_data_public'] ?? 'N') ?? false;

        return $instance;
    }
}
