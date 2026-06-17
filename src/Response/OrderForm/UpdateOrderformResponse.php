<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\OrderForm;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Update Orderform Response
 *
 * Response after updating an order form. The API reports whether the order form
 * was changed via `is_modified` (Y/N).
 *
 * @link https://digistore24.com/api/docs/paths/updateOrderform.yaml
 */
final class UpdateOrderformResponse extends AbstractResponse
{
    public string $result = '';

    /** Whether the order form was modified by the update */
    public bool $isModified = false;

    public function wasSuccessful(): bool
    {
        return $this->result === 'success';
    }

    public function wasModified(): bool
    {
        return $this->isModified;
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->isModified = TypeConverter::toBool($innerData['is_modified'] ?? null, false) ?? false;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
