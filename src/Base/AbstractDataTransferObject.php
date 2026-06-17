<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Base;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Contract\DataTransferObjectInterface;
use GoSuccess\Digistore24\Api\Contract\IntBackedEnum;
use GoSuccess\Digistore24\Api\Contract\StringBackedEnum;
use GoSuccess\Digistore24\Api\Util\TypeConverter;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;

/**
 * Abstract Data Transfer Object
 *
 * Provides automatic serialization/deserialization for DTOs using Reflection.
 * Supports:
 * - Basic types (string, int, float, bool)
 * - Nullable types
 * - Arrays (including typed arrays via PHPDoc @var)
 * - DateTime objects
 * - Enums (StringBackedEnum, IntBackedEnum)
 * - Nested DTOs
 * - Property hooks (get/set)
 *
 * Usage:
 * - GET Response DTOs: Extend this class, use property hooks with `get =>`
 * - Request DTOs: Extend this class, use public properties or `set` hooks
 */
abstract class AbstractDataTransferObject implements DataTransferObjectInterface
{
    /**
     * Create instance from array
     *
     * @param array<string, mixed> $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $reflection = new ReflectionClass(static::class);

        // Always build without invoking the constructor and assign via setRawValue,
        // so validating set hooks never fire while parsing trusted API data. The
        // constructor's default values are seeded first so that properties the
        // response omits remain initialized.
        $instance = $reflection->newInstanceWithoutConstructor();

        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $param) {
                if ($param->isDefaultValueAvailable() && $reflection->hasProperty($param->getName())) {
                    $reflection->getProperty($param->getName())->setRawValue($instance, $param->getDefaultValue());
                }
            }
        }

        $instanceReflection = new ReflectionClass($instance);
        // @phpstan-ignore argument.type (ReflectionClass<static> cannot be covariant to ReflectionClass<object>)
        self::setPropertiesFromArray($instance, $data, $instanceReflection);

        /** @var static */
        return $instance;
    }

    /**
     * Convert instance to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $data = [];

        foreach ($reflection->getProperties() as $property) {
            // Skip static properties
            if ($property->isStatic()) {
                continue;
            }

            $name = $property->getName();
            $value = $property->getValue($this);

            // Skip null values for optional properties
            if ($value === null) {
                continue;
            }

            // Convert property name to snake_case for API
            $key = self::camelToSnake($name);

            // Convert value based on type
            if ($value instanceof DataTransferObjectInterface) {
                $data[$key] = $value->toArray();
            } elseif ($value instanceof DateTimeImmutable) {
                $data[$key] = $value->format('Y-m-d H:i:s');
            } elseif ($value instanceof \BackedEnum) {
                $data[$key] = $value->value;
            } elseif (is_array($value)) {
                $data[$key] = array_map(function ($item) {
                    if ($item instanceof DataTransferObjectInterface) {
                        return $item->toArray();
                    }
                    if ($item instanceof \BackedEnum) {
                        return $item->value;
                    }

                    return $item;
                }, $value);
            } elseif (is_bool($value)) {
                // Convert bool to Y/N for Digistore24 API
                $data[$key] = $value ? 'Y' : 'N';
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Set properties from array for instances without constructor parameters
     *
     * @param object $instance
     * @param array<string, mixed> $data
     * @param ReflectionClass<object> $reflection
     */
    private static function setPropertiesFromArray(object $instance, array $data, ReflectionClass $reflection): void
    {
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $name = $property->getName();
            $snakeCaseName = self::camelToSnake($name);

            // Try both camelCase and snake_case
            if (! isset($data[$name]) && ! isset($data[$snakeCaseName])) {
                continue;
            }

            $value = $data[$name] ?? $data[$snakeCaseName];
            $type = $property->getType();

            // Use setRawValue so validating set hooks are bypassed when parsing an
            // API response: user input is validated, but inbound API data is trusted
            // and must not throw if it does not match a strict input format.
            if ($type instanceof ReflectionNamedType) {
                $convertedValue = self::convertValue($value, $type, $type->allowsNull());
                $property->setRawValue($instance, $convertedValue);
            } else {
                $property->setRawValue($instance, $value);
            }
        }
    }

    /**
     * Convert value to target type
     *
     * @param mixed $value
     * @param ReflectionNamedType $type
     * @param bool $allowsNull
     * @return mixed
     */
    private static function convertValue(mixed $value, ReflectionNamedType $type, bool $allowsNull): mixed
    {
        if ($value === null && $allowsNull) {
            return null;
        }

        $typeName = $type->getName();

        return match ($typeName) {
            'string' => TypeConverter::toString($value) ?? '',
            'int' => TypeConverter::toInt($value) ?? 0,
            'float' => TypeConverter::toFloat($value) ?? 0.0,
            'bool' => TypeConverter::toBool($value) ?? false,
            'array' => TypeConverter::toArray($value) ?? [],
            DateTimeImmutable::class, 'DateTimeImmutable' => TypeConverter::toDateTime($value),
            default => self::convertComplexType($value, $typeName, $allowsNull),
        };
    }

    /**
     * Convert complex types (Enums, DTOs)
     *
     * @param mixed $value
     * @param string $typeName
     * @param bool $allowsNull
     * @return mixed
     */
    private static function convertComplexType(mixed $value, string $typeName, bool $allowsNull): mixed
    {
        if ($value === null && $allowsNull) {
            return null;
        }

        // Check if it's an Enum
        if (enum_exists($typeName)) {
            return self::convertEnumValue($value, $typeName);
        }

        // Check if it's a DTO
        if (is_subclass_of($typeName, DataTransferObjectInterface::class) && is_array($value)) {
            return self::convertDtoValue($value, $typeName);
        }

        return $value;
    }

    /**
     * Convert value to enum instance
     *
     * @param mixed $value
     * @param class-string $enumClass
     * @return mixed
     */
    private static function convertEnumValue(mixed $value, string $enumClass): mixed
    {
        if (is_subclass_of($enumClass, StringBackedEnum::class)) {
            if (! is_scalar($value) && $value !== null) {
                return null;
            }
            $stringValue = is_string($value) ? $value : (string)$value;

            return $enumClass::fromString($stringValue);
        }

        if (is_subclass_of($enumClass, IntBackedEnum::class)) {
            if (! is_scalar($value) && $value !== null) {
                return null;
            }
            $intValue = is_int($value) ? $value : (int)$value;

            return $enumClass::fromInt($intValue);
        }

        // Fallback for standard backed enums
        if (method_exists($enumClass, 'from') && (is_int($value) || is_string($value))) {
            return $enumClass::from($value);
        }

        return null;
    }

    /**
     * Convert array to DTO instance
     *
     * @param array<mixed, mixed> $value
     * @param class-string<DataTransferObjectInterface> $dtoClass
     * @return DataTransferObjectInterface
     */
    private static function convertDtoValue(array $value, string $dtoClass): DataTransferObjectInterface
    {
        /** @var array<string, mixed> $stringKeyArray */
        $stringKeyArray = [];
        foreach ($value as $k => $v) {
            $stringKeyArray[(string)$k] = $v;
        }

        return $dtoClass::fromArray($stringKeyArray);
    }

    /**
     * Convert camelCase to snake_case
     */
    private static function camelToSnake(string $input): string
    {
        $result = preg_replace('/([a-z])([A-Z])/', '$1_$2', $input);

        return $result !== null ? strtolower($result) : $input;
    }
}
