<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\BuyUrl;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Buy URLs Request
 *
 * Retrieves a list of all generated buy URLs.
 *
 * @link https://digistore24.com/api/docs/paths/listBuyUrls.yaml
 */
final class ListBuyUrlsRequest extends AbstractRequest
{
    public function getEndpoint(): string
    {
        return '/listBuyUrls';
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
