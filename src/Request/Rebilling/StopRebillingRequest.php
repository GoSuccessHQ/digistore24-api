<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Rebilling;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Stop Rebilling Request
 *
 * Stops automatic rebilling for a purchase or subscription.
 *
 * @link https://digistore24.com/api/docs/paths/stopRebilling.yaml
 */
final class StopRebillingRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The Digistore24 order ID
     * @param bool|null $force Cancel immediately when true; respects the minimum duration when false (default)
     * @param bool|null $ignoreRefundPossibility When false (default), cancels immediately if a refund is available; when true, waits until the end of the cancellation period
     */
    public function __construct(
        private string $purchaseId,
        private ?bool $force = null,
        private ?bool $ignoreRefundPossibility = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/stopRebilling';
    }

    public function toArray(): array
    {
        $params = ['purchase_id' => $this->purchaseId];
        if ($this->force !== null) {
            $params['force'] = TypeConverter::fromBool($this->force);
        }
        if ($this->ignoreRefundPossibility !== null) {
            $params['ignore_refund_possibility'] = TypeConverter::fromBool($this->ignoreRefundPossibility);
        }

        return $params;
    }
}
