<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Marketplace;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Stats Marketplace Request
 *
 * Retrieves marketplace statistics, optionally for a specific language.
 *
 * @link https://digistore24.com/api/docs/paths/statsMarketplace.yaml
 */
final class StatsMarketplaceRequest extends AbstractRequest
{
    /**
     * @param string|null $language Language code (e.g. "de"); see getGlobalSettings for the list of languages
     */
    public function __construct(private ?string $language = null)
    {
    }

    public function getEndpoint(): string
    {
        return '/statsMarketplace';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $params = [];
        if ($this->language !== null) {
            $params['language'] = $this->language;
        }

        return $params;
    }
}
