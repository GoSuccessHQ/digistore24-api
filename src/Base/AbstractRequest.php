<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Base;

use GoSuccess\Digistore24\Api\Contract\DataTransferObjectInterface;
use GoSuccess\Digistore24\Api\Contract\RequestInterface;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Util\ArrayHelper;
use GoSuccess\Digistore24\Api\Util\Validator;

/**
 * Abstract Request Base Class
 *
 * Base class for all API request objects.
 * Uses PHP 8.4 features for clean, type-safe requests.
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * Get the API endpoint for this request
     */
    abstract public function getEndpoint(): string;

    /**
     * Get the HTTP method for this request
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    /**
     * Convert request to array for the API call.
     *
     * Public properties are serialized automatically: names are converted to
     * snake_case, null values are skipped, booleans become the Digistore24 'Y'/'N'
     * format, DateTime values are formatted, enums become their backing value, and
     * nested requests/DTOs are recursively converted. Subclasses only need to
     * override this when they wrap fields (e.g. under a `data` key) or read private
     * promoted properties that this reflection-free pass cannot see.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        foreach (get_object_vars($this) as $property => $value) {
            if ($value === null) {
                continue;
            }

            $data[ArrayHelper::toSnakeCase($property)] = $this->convertValue($value);
        }

        return $data;
    }

    /**
     * Convert a single value to its API representation.
     */
    private function convertValue(mixed $value): mixed
    {
        if ($value instanceof self || $value instanceof DataTransferObjectInterface) {
            return $value->toArray();
        }
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        if ($value instanceof \BackedEnum) {
            return $value->value;
        }
        if (is_bool($value)) {
            return $value ? 'Y' : 'N';
        }
        if (is_array($value)) {
            return $this->convertArray($value);
        }

        return $value;
    }

    /**
     * Convert array values recursively
     *
     * @param array<mixed> $array
     * @return array<mixed>
     */
    private function convertArray(array $array): array
    {
        return array_map(fn ($value) => $this->convertValue($value), $array);
    }

    /**
     * Validate the request
     *
     * @return array<string, string[]> Validation errors
     */
    public function validate(): array
    {
        $rules = $this->rules();

        if (empty($rules)) {
            return [];
        }

        // Convert complex rules format to simple string format for Validator
        /** @var array<string, string|array<int, string>> $simpleRules */
        $simpleRules = [];
        foreach ($rules as $field => $ruleConfig) {
            if (is_string($ruleConfig)) {
                $simpleRules[$field] = $ruleConfig;
            } elseif (is_array($ruleConfig)) {
                // Handle complex rule format with 'rule' key
                $simpleRules[$field] = $ruleConfig['rule'];
            }
        }

        $validationErrors = Validator::validate($this->toArray(), $simpleRules);

        // Convert array<string, string> to array<string, string[]> for interface compatibility
        $errors = [];
        foreach ($validationErrors as $field => $error) {
            $errors[$field] = [$error];
        }

        return $errors;
    }

    /**
     * Get validation rules
     *
     * Override in subclasses to define validation rules.
     *
     * @return array<string, string|array{rule: string, params?: array<mixed>, message?: string}>
     */
    protected function rules(): array
    {
        return [];
    }

    /**
     * Check if request is valid
     */
    public function isValid(): bool
    {
        return empty($this->validate());
    }

    /**
     * Ensure request is valid or throw exception
     *
     * @throws \InvalidArgumentException
     */
    public function ensureValid(): void
    {
        $errors = $this->validate();

        if (! empty($errors)) {
            $messages = [];
            foreach ($errors as $field => $fieldErrors) {
                $messages[] = "{$field}: " . implode(', ', $fieldErrors);
            }

            throw new \InvalidArgumentException(
                'Request validation failed: ' . implode('; ', $messages),
            );
        }
    }
}
