<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ConversionTool;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Conversion Tools Response
 *
 * Response object for the ConversionTool API endpoint.
 */
final class ListConversionToolsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Smart upgrades data
     *
     * @var array<string, mixed>
     */
    public array $smartupgrades = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $smartupgrades = $innerData['smartupgrades'] ?? [];
        if (! is_array($smartupgrades)) {
            $smartupgrades = [];
        }

        /** @var array<string, mixed> $validatedSmartupgrades */
        $validatedSmartupgrades = $smartupgrades;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->smartupgrades = $validatedSmartupgrades;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
