<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * List Upgrades Request
 *
 * Retrieves a list of all configured upgrade paths.
 */
final class ListUpgradesRequest extends AbstractRequest
{
    public function __construct()
    {
    }

    public function getEndpoint(): string
    {
        return '/listUpgrades';
    }
}
