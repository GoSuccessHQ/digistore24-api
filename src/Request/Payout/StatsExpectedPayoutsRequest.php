<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Payout;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Stats Expected Payouts Request
 *
 * Retrieves statistics about expected upcoming payouts.
 */
final class StatsExpectedPayoutsRequest extends AbstractRequest
{
    public function __construct()
    {
    }

    public function getEndpoint(): string
    {
        return '/statsExpectedPayouts';
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
