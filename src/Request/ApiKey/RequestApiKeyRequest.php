<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ApiKey;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\ApiPermissionLevel;

/**
 * Request API Key Request
 *
 * Starts the creation of a new API key. The response provides a URL the user
 * has to visit to confirm the new key, plus a token to retrieve the key later
 * via retrieveApiKey.
 *
 * @link https://digistore24.com/api/docs/paths/requestApiKey.yaml
 */
final class RequestApiKeyRequest extends AbstractRequest
{
    /**
     * @param ApiPermissionLevel $permissions Permission level for the new API key
     * @param string $returnUrl URL the user is redirected to after the API key was created
     * @param string|null $cancelUrl URL the user is redirected to if the creation is canceled
     * @param string|null $siteUrl Website URL to store together with the API key
     * @param string|null $comment Note for the new API key
     */
    public function __construct(
        public ApiPermissionLevel $permissions,
        public string $returnUrl,
        public ?string $cancelUrl = null,
        public ?string $siteUrl = null,
        public ?string $comment = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/requestApiKey';
    }

    public function toArray(): array
    {
        $data = [
            'permissions' => $this->permissions->value,
            'return_url' => $this->returnUrl,
        ];

        if ($this->cancelUrl !== null) {
            $data['cancel_url'] = $this->cancelUrl;
        }

        if ($this->siteUrl !== null) {
            $data['site_url'] = $this->siteUrl;
        }

        if ($this->comment !== null) {
            $data['comment'] = $this->comment;
        }

        return $data;
    }
}
