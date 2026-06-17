<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Product;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Request to list all available product types.
 *
 * This endpoint returns a list of all product types available in Digistore24,
 * including their IDs, names, and categories. Use these product types when
 * creating or updating products.
 *
 * @see https://digistore24.com/api/docs/paths/listProductTypes.yaml
 */
final class ListProductTypesRequest extends AbstractRequest
{
    public function __construct()
    {
        // No parameters required for this endpoint
    }

    public function getEndpoint(): string
    {
        return '/listProductTypes';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return [];
    }
}
