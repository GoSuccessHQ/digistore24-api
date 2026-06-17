<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\System;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Request to ping the Digistore24 server.
 *
 * Tests the connection to the Digistore24 server and determines the server time.
 * Useful for connectivity checks and time synchronization.
 *
 * @see https://digistore24.com/api/docs/paths/ping.yaml
 */
final class PingRequest extends AbstractRequest
{
    public function __construct()
    {
        // No parameters required
    }

    public function getEndpoint(): string
    {
        return '/ping';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
