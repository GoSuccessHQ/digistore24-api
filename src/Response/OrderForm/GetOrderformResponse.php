<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\OrderForm;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Orderform Response
 *
 * Response containing a single order form data record. The API wraps the record
 * under an `orderform` key; the complete record is exposed via {@see self::$data}.
 *
 * @link https://digistore24.com/api/docs/paths/getOrderform.yaml
 */
final class GetOrderformResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The complete order form record as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        // The record is wrapped under `orderform`; support a flat payload too.
        $orderform = $innerData['orderform'] ?? $innerData;
        if (! is_array($orderform)) {
            $orderform = [];
        }
        /** @var array<string, mixed> $validatedData */
        $validatedData = $orderform;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $validatedData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
