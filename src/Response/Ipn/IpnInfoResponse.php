<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Ipn;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * IPN Info Response
 *
 * Response containing IPN connection settings.
 * Returns the settings that were transferred when the connection was created.
 */
final class IpnInfoResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * IPN URL
     */
    public ?string $url = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->url = is_string($innerData['url'] ?? null) ? $innerData['url'] : null;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
