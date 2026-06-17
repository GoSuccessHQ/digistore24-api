<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Marketplace;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Marketplace Entry Request
 *
 * Retrieves detailed information about a specific marketplace entry.
 */
final class GetMarketplaceEntryRequest extends AbstractRequest
{
    /**
     * @param string $entryId The unique identifier of the marketplace entry
     */
    public function __construct(private string $entryId)
    {
    }

    public function getEndpoint(): string
    {
        return '/getMarketplaceEntry';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['entry_id' => $this->entryId];
    }
}
