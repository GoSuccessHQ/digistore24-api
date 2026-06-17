<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ConversionTool;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Validate Coupon Code Response
 *
 * Response object for the ConversionTool API endpoint.
 */
final class ValidateCouponCodeResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Validation status
     */
    public string $status = '';

    /**
     * Coupon data
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * Check if coupon is valid
     */
    public function isValid(): bool
    {
        return $this->status === 'success';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        /** @var array<string, mixed> $validatedCouponData */
        $validatedCouponData = $innerData;

        $status = $validatedCouponData['status'] ?? '';

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->status = is_string($status) ? $status : '';
        $response->data = $validatedCouponData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
