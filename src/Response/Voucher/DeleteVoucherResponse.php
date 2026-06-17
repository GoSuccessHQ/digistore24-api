<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Voucher;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Delete Voucher Response
 *
 * Response object for the deleteVoucher API endpoint.
 * Indicates successful deletion of a voucher.
 */
final class DeleteVoucherResponse extends AbstractResponse
{
    /**
     * Result of the delete operation
     */
    public string $result = '';

    /**
     * Create response from API data
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $instance = new self();

        if ($rawResponse !== null) {
            $instance->rawResponse = $rawResponse;
        }

        $instance->result = self::extractResult(data: $data, rawResponse: $rawResponse);

        return $instance;
    }
}
