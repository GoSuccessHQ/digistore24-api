<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\AccountAccess;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Log Member Access Response
 *
 * Response after successfully logging member access.
 */
final class LogMemberAccessResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Whether the access was successfully logged
     */
    public bool $success = true;

    /**
     * Optional message from the API
     */
    public ?string $message = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->success = TypeConverter::toBool($innerData['success'] ?? true) ?? true;
        $response->message = isset($innerData['message']) ? TypeConverter::toString($innerData['message']) : null;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
