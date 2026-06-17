<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\AccountAccess;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Account Access Request
 *
 * Lists all logged member accesses for a specific purchase.
 * Provides history of when buyers accessed their membership content.
 */
final class ListAccountAccessRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The unique identifier of the purchase
     */
    public function __construct(
        public readonly string $purchaseId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listAccountAccess';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return [
            'purchase_id' => $this->purchaseId,
        ];
    }
}
