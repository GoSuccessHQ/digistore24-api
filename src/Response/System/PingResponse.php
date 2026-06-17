<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\System;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Response from pinging the Digistore24 server.
 *
 * Contains server time, API version, and runtime information.
 */
final class PingResponse extends AbstractResponse
{
    /**
     * API version
     */
    public string $apiVersion = '';

    /**
     * Current server time
     */
    public ?DateTimeImmutable $currentTime = null;

    /**
     * Runtime in seconds
     */
    public float $runtimeSeconds = 0.0;

    /**
     * Result status
     */
    public string $result = '';

    /**
     * Server time from data field
     */
    public ?DateTimeImmutable $serverTime = null;

    /**
     * Check if ping was successful
     */
    public function wasSuccessful(): bool
    {
        return strtolower($this->result) === 'success'
            || strtolower($this->result) === 'ok';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        // For ping, we need top-level fields from rawResponse if available
        $topLevel = $rawResponse !== null ? $rawResponse->data : $data;
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->apiVersion = TypeConverter::toString($topLevel['api_version'] ?? null) ?? '';
        $response->currentTime = TypeConverter::toDateTime($topLevel['current_time'] ?? null);
        $response->runtimeSeconds = TypeConverter::toFloat($topLevel['runtime_seconds'] ?? null) ?? 0.0;
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->serverTime = TypeConverter::toDateTime($innerData['server_time'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
