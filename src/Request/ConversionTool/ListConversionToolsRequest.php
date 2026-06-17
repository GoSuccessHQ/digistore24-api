<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ConversionTool;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Conversion Tools Request
 *
 * Retrieves a list of conversion tools (vouchers, coupons) by type.
 */
final class ListConversionToolsRequest extends AbstractRequest
{
    /**
     * @param string $type The conversion tool type (e.g., 'voucher', 'coupon')
     */
    public function __construct(
        private string $type,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listConversionTools';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['type' => $this->type];
    }
}
