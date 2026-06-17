<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Upgrade Request
 *
 * Retrieves detailed information about a specific upgrade path.
 */
final class GetUpgradeRequest extends AbstractRequest
{
    /**
     * @param string $upgradeId The unique identifier of the upgrade
     */
    public function __construct(private string $upgradeId)
    {
    }

    public function getEndpoint(): string
    {
        return '/getUpgrade';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['upgrade_id' => $this->upgradeId];
    }
}
