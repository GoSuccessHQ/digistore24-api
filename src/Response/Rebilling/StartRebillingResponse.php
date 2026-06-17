<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\RebillingData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Start Rebilling Response
 *
 * Response for resuming rebilling payments.
 */
final class StartRebillingResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Rebilling data
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
