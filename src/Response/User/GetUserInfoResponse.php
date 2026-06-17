<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\User;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get User Info Response
 *
 * Information about the current user (the owner of the API key). The spec
 * fields are exposed as typed properties; the complete payload is also
 * available via {@see $userInfo}.
 *
 * @link https://digistore24.com/api/docs/paths/getUserInfo.yaml
 */
final class GetUserInfoResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Numeric ID of the API key holder (spec key: `user_id`)
     */
    public ?int $userId = null;

    /**
     * Digistore ID / login name (spec key: `user_name`)
     */
    public ?string $userName = null;

    /**
     * Comma-separated list of role codes (spec key: `granted_roles`)
     */
    public ?string $grantedRoles = null;

    /**
     * Comma-separated list of role names in plain text (spec key: `granted_roles_msg`)
     */
    public ?string $grantedRolesMsg = null;

    /**
     * The complete user info payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $userInfo = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->userId = TypeConverter::toInt($innerData['user_id'] ?? null);
        $response->userName = TypeConverter::toString($innerData['user_name'] ?? null);
        $response->grantedRoles = TypeConverter::toString($innerData['granted_roles'] ?? null);
        $response->grantedRolesMsg = TypeConverter::toString($innerData['granted_roles_msg'] ?? null);
        $response->userInfo = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
