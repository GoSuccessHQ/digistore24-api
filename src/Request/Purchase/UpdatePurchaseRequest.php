<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Request to update a purchase
 *
 * @link https://digistore24.com/api/docs/paths/updatePurchase.yaml OpenAPI Specification
 */
final class UpdatePurchaseRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The ID of the purchase to update
     * @param string|null $trackingParam The vendor's tracking key
     * @param string|null $custom The custom field
     * @param bool|null $unlockInvoices Grant buyer access to order details and invoices
     * @param string|null $nextPaymentAt Extend rebilling payment interval (date-time format)
     */
    public function __construct(
        public string $purchaseId,
        public ?string $trackingParam = null,
        public ?string $custom = null,
        public ?bool $unlockInvoices = null,
        public ?string $nextPaymentAt = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/updatePurchase';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }
}
