<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Voucher;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Voucher Response
 *
 * Response object for the createVoucher API endpoint.
 * Returns the ID and code of the newly created voucher.
 */
final class CreateVoucherResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * ID of the created voucher
     */
    public int $discountCodeId = 0;

    /**
     * The voucher code
     */
    public string $code = '';

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
        $instance->discountCodeId = TypeConverter::toInt(value: $innerData['discount_code_id'] ?? 0) ?? 0;
        $instance->code = TypeConverter::toString(value: $innerData['code'] ?? '') ?? '';

        return $instance;
    }
}
