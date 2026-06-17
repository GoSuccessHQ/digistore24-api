<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Tracking;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Response containing JavaScript tracking code.
 *
 * @see https://digistore24.com/api/docs/paths/renderJsTrackingCode.yaml
 */
final class RenderJsTrackingCodeResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * The complete JavaScript tag to be embedded
     */
    public string $scriptCode = '';

    /**
     * The script URL
     */
    public string $scriptUrl = '';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->scriptCode = is_string($innerData['script_code'] ?? null) ? $innerData['script_code'] : '';
        $response->scriptUrl = is_string($innerData['script_url'] ?? null) ? $innerData['script_url'] : '';

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
