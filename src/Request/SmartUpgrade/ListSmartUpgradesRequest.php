<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\SmartUpgrade;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Smart Upgrades Request
 *
 * Retrieves a list of all configured smart upgrade paths.
 */
final class ListSmartUpgradesRequest extends AbstractRequest
{
    public function __construct()
    {
    }

    public function getEndpoint(): string
    {
        return '/listSmartUpgrades';
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
