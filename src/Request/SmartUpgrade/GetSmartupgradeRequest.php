<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\SmartUpgrade;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Smart Upgrade Request
 *
 * Retrieves detailed information about a specific smart upgrade configuration.
 */
final class GetSmartupgradeRequest extends AbstractRequest
{
    /**
     * @param string $smartupgradeId The unique identifier of the smart upgrade
     * @param string|null $purchaseId Optional purchase ID to check upgrade eligibility
     */
    public function __construct(private string $smartupgradeId, private ?string $purchaseId = null)
    {
    }

    public function getEndpoint(): string
    {
        return '/getSmartupgrade';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $params = ['smartupgrade_id' => $this->smartupgradeId];
        if ($this->purchaseId !== null) {
            $params['purchase_id'] = $this->purchaseId;
        }

        return $params;
    }
}
