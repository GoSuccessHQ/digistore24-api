<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\OrderForm;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Orderform Response
 *
 * Response after creating an order form. The API returns the new order form's
 * ID under `orderform_id`.
 *
 * @link https://digistore24.com/api/docs/paths/createOrderform.yaml
 */
final class CreateOrderformResponse extends AbstractResponse
{
    public string $result = '';

    /** ID of the newly created order form */
    public ?int $orderformId = null;

    /**
     * The complete response payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public function getOrderformId(): ?string
    {
        $value = $this->data['orderform_id'] ?? null;

        if (is_string($value)) {
            return $value;
        }

        return $value !== null ? TypeConverter::toString($value) : null;
    }

    public function wasSuccessful(): bool
    {
        return $this->result === 'success';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $responseData = self::extractInnerData($data);
        /** @var array<string, mixed> $validatedData */
        $validatedData = $responseData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->orderformId = TypeConverter::toInt($validatedData['orderform_id'] ?? null);
        $response->data = $validatedData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
