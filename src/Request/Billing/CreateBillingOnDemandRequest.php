<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Billing;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\BillingAddonData;
use GoSuccess\Digistore24\Api\DTO\BillingPaymentPlanData;
use GoSuccess\Digistore24\Api\DTO\BillingSettingsData;
use GoSuccess\Digistore24\Api\DTO\PlaceholderData;
use GoSuccess\Digistore24\Api\DTO\TrackingData;

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
 * Each structured parameter accepts either the matching typed DTO or a raw array,
 * so callers can use the strongly typed objects or pass pre-built payloads.
 *
 * @see https://digistore24.com/api/docs/paths/createBillingOnDemand.yaml
 */
final class CreateBillingOnDemandRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The reference order (must support rebilling)
     * @param string $productId The product ID in Digistore24
     * @param BillingPaymentPlanData|array<string, mixed>|null $paymentPlan Payment plan configuration
     * @param TrackingData|array<string, string>|null $tracking Tracking data (custom, affiliate, campaignkey, trackingkey)
     * @param PlaceholderData|array<string, string>|null $placeholders Placeholders for product title and description
     * @param BillingSettingsData|array<string, mixed>|null $settings Additional settings (voucher_code, quantity, product_country)
     * @param array<int, BillingAddonData|array<string, mixed>>|null $addons List of add-on products
     */
    public function __construct(
        private string $purchaseId,
        private string $productId,
        private BillingPaymentPlanData|array|null $paymentPlan = null,
        private TrackingData|array|null $tracking = null,
        private PlaceholderData|array|null $placeholders = null,
        private BillingSettingsData|array|null $settings = null,
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
            $params['payment_plan'] = $this->paymentPlan instanceof BillingPaymentPlanData
                ? $this->paymentPlan->toArray()
                : $this->paymentPlan;
        }

        if ($this->tracking !== null) {
            $params['tracking'] = $this->tracking instanceof TrackingData
                ? $this->tracking->toArray()
                : $this->tracking;
        }

        if ($this->placeholders !== null) {
            $params['placeholders'] = $this->placeholders instanceof PlaceholderData
                ? $this->placeholders->toArray()
                : $this->placeholders;
        }

        if ($this->settings !== null) {
            $params['settings'] = $this->settings instanceof BillingSettingsData
                ? $this->settings->toArray()
                : $this->settings;
        }

        if ($this->addons !== null) {
            $params['addons'] = array_map(
                static fn (BillingAddonData|array $addon): array => $addon instanceof BillingAddonData
                    ? $addon->toArray()
                    : $addon,
                $this->addons,
            );
        }

        return $params;
    }
}
