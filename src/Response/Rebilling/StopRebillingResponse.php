<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\RebillingData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Stop Rebilling Response
 *
 * Response for stopping rebilling payments.
 * Contains detailed information about cancellation status and timing.
 */
final class StopRebillingResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Rebilling data including cancellation details
     */
    public ?RebillingData $data = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $rebillingData = empty($innerData) ? null : RebillingData::fromArray($innerData);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $rebillingData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
