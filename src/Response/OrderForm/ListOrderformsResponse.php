<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\OrderForm;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Orderforms Response
 *
 * Response object for the OrderForm API endpoint.
 */
final class ListOrderformsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<string, mixed> */
    public array $orderforms = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $orderformsData = $innerData['orderforms'] ?? [];
        if (! is_array($orderformsData)) {
            $orderformsData = [];
        }
        /** @var array<string, mixed> $validatedOrderforms */
        $validatedOrderforms = $orderformsData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->orderforms = $validatedOrderforms;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
