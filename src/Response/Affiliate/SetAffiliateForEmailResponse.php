<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Set Affiliate For Email Response
 *
 * Response object for assigning an affiliate to an email address. The spec
 * returns no specific data for this endpoint, so only the result status and the
 * raw data net are exposed.
 *
 * @link https://digistore24.com/api/docs/paths/setAffiliateForEmail.yaml
 */
final class SetAffiliateForEmailResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * The complete payload as returned by the API. No specific data is returned
     * for this endpoint, but the net is retained for forward compatibility.
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
