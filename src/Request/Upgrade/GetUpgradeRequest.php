<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Upgrade Request
 *
 * Retrieves detailed information about a specific upgrade path. When order IDs
 * are supplied, the response also reports whether the upgrade is possible for
 * those orders.
 *
 * @link https://digistore24.com/api/docs/paths/getUpgrade.yaml
 */
final class GetUpgradeRequest extends AbstractRequest
{
    /**
     * @param string $upgradeId The numeric ID of the upgrade to retrieve
     * @param string|null $orderIds Comma-separated list of order IDs to check upgrade possibility for
     */
    public function __construct(
        private string $upgradeId,
        private ?string $orderIds = null,
    ) {
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
        $params = ['upgrade_id' => $this->upgradeId];
        if ($this->orderIds !== null) {
            $params['order_ids'] = $this->orderIds;
        }

        return $params;
    }
}
