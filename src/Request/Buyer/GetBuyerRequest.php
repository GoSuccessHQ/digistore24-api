<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Buyer;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Buyer Request
 *
 * Retrieves buyer information by buyer ID or email address.
 */
final class GetBuyerRequest extends AbstractRequest
{
    /**
     * @param string $buyerId The buyer ID or email address
     */
    public function __construct(
        private string $buyerId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/getBuyer';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['buyer_id' => $this->buyerId];
    }
}
