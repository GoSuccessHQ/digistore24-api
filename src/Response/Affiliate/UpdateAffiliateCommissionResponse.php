<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Update Affiliate Commission Response
 *
 * Response object for updating affiliate commission settings. The spec returns
 * an empty `data` object on success, so only the result status and the raw data
 * net are exposed.
 *
 * @link https://digistore24.com/api/docs/paths/updateAffiliateCommission.yaml
 */
final class UpdateAffiliateCommissionResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * The complete payload as returned by the API. Empty on success per the
     * spec, but retained so any future fields remain accessible.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
