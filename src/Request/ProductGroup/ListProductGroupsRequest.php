<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ProductGroup;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Product Groups Request
 *
 * Retrieves a list of all product groups.
 */
final class ListProductGroupsRequest extends AbstractRequest
{
    public function __construct()
    {
    }

    public function getEndpoint(): string
    {
        return '/listProductGroups';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
