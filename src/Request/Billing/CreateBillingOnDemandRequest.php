<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Billing;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Request to create a billing on demand order.
 *
 * Creates a customized order that uses the payment method from a reference purchase.
 * This allows creating new orders without requiring the customer to re-enter payment details.
 *
 * Requirements:
 * - "Billing on demand" right must be enabled for the vendor account
 * - Reference purchase must use a payment method that supports rebilling
 *
 * @see https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml
 */
final class CreateBillingOnDemandRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The reference order (must support rebilling)
     * @param string $productId The product ID in Digistore24
     * @param array<string, mixed>|null $paymentPlan Payment plan configuration (first_amount, other_amounts, currency, etc.)
     * @param array<string, string>|null $tracking Tracking data (custom, affiliate, campaignkey, trackingkey)
     * @param array<string, string>|null $placeholders Placeholders for product title and description
     * @param array<string, mixed>|null $settings Additional settings (voucher_code, quantity, product_country)
     * @param array<int, array<string, mixed>>|null $addons List of add-on products
     */
    public function __construct(
        private string $purchaseId,
        private string $productId,
        private ?array $paymentPlan = null,
        private ?array $tracking = null,
        private ?array $placeholders = null,
        private ?array $settings = null,
        private ?array $addons = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/createBillingOnDemand';
    }

    public function toArray(): array
    {
        $params = [
            'purchase_id' => $this->purchaseId,
            'product_id' => $this->productId,
        ];

        if ($this->paymentPlan !== null) {
            $params['payment_plan'] = $this->paymentPlan;
        }

        if ($this->tracking !== null) {
            $params['tracking'] = $this->tracking;
        }

        if ($this->placeholders !== null) {
            $params['placeholders'] = $this->placeholders;
        }

        if ($this->settings !== null) {
            $params['settings'] = $this->settings;
        }

        if ($this->addons !== null) {
            $params['addons'] = $this->addons;
        }

        return $params;
    }
}
