<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\AccountAccess;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Account Access Request
 *
 * Lists the account access permissions granted by and to the API key owner.
 * The endpoint takes no parameters.
 *
 * @link https://digistore24.com/api/docs/paths/listAccountAccess.yaml
 */
final class ListAccountAccessRequest extends AbstractRequest
{
    public function __construct()
    {
    }

    public function getEndpoint(): string
    {
        return '/listAccountAccess';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
