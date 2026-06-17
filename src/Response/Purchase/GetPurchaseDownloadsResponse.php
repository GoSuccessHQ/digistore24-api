<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Purchase Downloads Response
 *
 * Response object for the Purchase API endpoint.
 */
final class GetPurchaseDownloadsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $downloads = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $downloads = $innerData['downloads'] ?? [];
        if (! is_array($downloads)) {
            $downloads = [];
        }
        /** @var array<string, mixed> $validatedDownloads */
        $validatedDownloads = $downloads;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->downloads = $validatedDownloads;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
