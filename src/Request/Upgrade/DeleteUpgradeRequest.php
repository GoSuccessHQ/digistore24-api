<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Delete Upgrade Request
 *
 * Deletes an existing upgrade path by its unique identifier.
 */
final class DeleteUpgradeRequest extends AbstractRequest
{
    /**
     * @param string $upgradeId The unique identifier of the upgrade to delete
     */
    public function __construct(private string $upgradeId)
    {
    }

    public function getEndpoint(): string
    {
        return '/deleteUpgrade';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE;
    }

    public function toArray(): array
    {
        return ['upgrade_id' => $this->upgradeId];
    }
}
