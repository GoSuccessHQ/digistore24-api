<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Marketplace;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Marketplace Entries Request
 *
 * Retrieves a list of all marketplace entries, optionally sorted.
 *
 * @link https://digistore24.com/api/docs/paths/listMarketplaceEntries.yaml
 */
final class ListMarketplaceEntriesRequest extends AbstractRequest
{
    /**
     * @param string|null $sortBy Sorting criteria for marketplace entries
     */
    public function __construct(private ?string $sortBy = null)
    {
    }

    public function getEndpoint(): string
    {
        return '/listMarketplaceEntries';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $params = [];
        if ($this->sortBy !== null) {
            $params['sort_by'] = $this->sortBy;
        }

        return $params;
    }
}
