<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Base;

use GoSuccess\Digistore24\Api\Contract\ResponseInterface;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Abstract Response Base Class
 *
 * Base class for all API response objects.
 * Uses PHP 8.4 features for automatic type conversion.
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * Raw HTTP response
     */
    public Response $rawResponse;

    /**
     * Create response from HTTP response
     *
     * @param Response $response Raw HTTP response
     * @return static
     */
    public static function fromResponse(Response $response): static
    {
        // Digistore24 API wraps data in a "data" field
        // Example: {"api_version": "1.2", "result": "success", "data": {...}}
        $responseData = $response->data['data'] ?? $response->data;

        if (! is_array($responseData)) {
            $responseData = [];
        }

        // Ensure string keys for array<string, mixed>
        /** @var array<string, mixed> $validatedData */
        $validatedData = $responseData;

        $instance = static::fromArray($validatedData, $response);
        $instance->rawResponse = $response;

        return $instance;
    }

    /**
     * Create response from array data
     *
     * @param array<string, mixed> $data Response data
     * @param Response|null $rawResponse Raw HTTP response
     * @return static
     */
    abstract public static function fromArray(array $data, ?Response $rawResponse = null): static;

    /**
     * Get a value from data with type conversion
     *
     * @param array<string, mixed> $data Source data array
     * @param string $key Key to retrieve
     * @param string $type Expected type for conversion
     * @param mixed $default Default value if key not found (explicitly pass null if no default needed)
     * @return mixed
     */
    protected static function getValue(array $data, string $key, string $type, mixed $default): mixed
    {
        $value = $data[$key] ?? $default;

        if ($value === null || $value === '') {
            return $default;
        }

        return match ($type) {
            'int', 'integer' => TypeConverter::toInt($value),
            'float', 'double' => TypeConverter::toFloat($value),
            'bool', 'boolean' => TypeConverter::toBool($value),
            'datetime', 'datetime_immutable' => TypeConverter::toDateTime($value),
            'array' => TypeConverter::toArray($value),
            'string' => TypeConverter::toString($value),
            default => $value,
        };
    }

    /**
     * Extract result field from response data or rawResponse
     *
     * Handles both direct fromArray() calls (where $data contains 'result')
     * and fromResponse() calls (where result is in rawResponse->data['result'])
     *
     * @param array<string, mixed> $data
     */
    protected static function extractResult(array $data, ?Response $rawResponse, string $default = 'unknown'): string
    {
        $result = $rawResponse?->data['result'] ?? $data['result'] ?? $default;

        return is_string($result) ? $result : $default;
    }

    /**
     * Extract inner data array, handling nested 'data' field
     *
     * When fromArray() is called directly (tests), $data may contain: {'result': ..., 'data': {...}}
     * When called via fromResponse(), $data is already the inner data object
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected static function extractInnerData(array $data): array
    {
        // If data has a nested 'data' field, use that, otherwise use data directly
        $innerData = $data['data'] ?? $data;

        if (! is_array($innerData)) {
            return [];
        }

        // Ensure string keys
        /** @var array<string, mixed> */
        return $innerData;
    }

    /**
     * Get array of values with type conversion
     *
     * @param array<string, mixed> $data
     * @param string $key
     * @param class-string $itemClass Item class for nested objects
     * @param Response|null $rawResponse Raw HTTP response to pass to nested objects
     * @return array<mixed>
     */
    protected static function getArray(array $data, string $key, ?string $itemClass = null, ?Response $rawResponse = null): array
    {
        $value = $data[$key] ?? [];

        if (! is_array($value)) {
            return [];
        }

        if ($itemClass === null) {
            return $value;
        }

        // Convert array items to objects
        return array_map(
            function ($item) use ($itemClass, $rawResponse) {
                if (! is_array($item)) {
                    return $item;
                }

                // Ensure string keys for array<string, mixed>
                /** @var array<string, mixed> $validatedItem */
                $validatedItem = $item;

                return is_subclass_of($itemClass, self::class)
                    ? $itemClass::fromArray($validatedItem, $rawResponse)
                    : $validatedItem;
            },
            $value,
        );
    }

    /**
     * Convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        foreach (get_object_vars($this) as $property => $value) {
            $property = (string)$property;
            if ($property === 'rawResponse') {
                continue;
            }

            if ($value instanceof self) {
                $data[$property] = $value->toArray();
            } elseif (is_array($value)) {
                $data[$property] = array_map(
                    fn ($item) => $item instanceof self ? $item->toArray() : $item,
                    $value,
                );
            } elseif ($value instanceof \DateTimeInterface) {
                $data[$property] = $value->format('Y-m-d H:i:s');
            } elseif ($value instanceof \BackedEnum) {
                $data[$property] = $value->value;
            } else {
                $data[$property] = $value;
            }
        }

        return $data;
    }
}
