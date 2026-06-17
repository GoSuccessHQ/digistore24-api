<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\User;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get User Info Response
 *
 * Response object for the User API endpoint.
 */
final class GetUserInfoResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * User info data
     *
     * @var array<string, mixed>
     */
    public array $userInfo = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->userInfo = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
