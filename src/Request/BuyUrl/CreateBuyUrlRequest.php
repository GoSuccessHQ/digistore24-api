<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\BuyUrl;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\DTO\BuyUrlAddonData;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanData;
use GoSuccess\Digistore24\Api\DTO\SettingsData;
use GoSuccess\Digistore24\Api\DTO\TrackingData;
use GoSuccess\Digistore24\Api\DTO\UrlsData;

/**
 * Create Buy URL Request
 *
 * Request object for creating a customized order form URL.
 * Uses PHP 8.4 property hooks for automatic validation.
 *
 * @link https://digistore24.com/api/docs/paths/createBuyUrl.yaml
 */
final class CreateBuyUrlRequest extends AbstractRequest
{
    public string|int $productId {
        set {
            if (empty($value)) {
                throw new \InvalidArgumentException('Product ID is required');
            }
            $this->productId = $value;
        }
    }

    /** Prefilled buyer data shown on (and optionally locked on) the order form */
    public ?BuyerData $buyer = null;

    /** Custom pricing/payment configuration overriding the product defaults */
    public ?PaymentPlanData $paymentPlan = null;

    /** Affiliate and campaign tracking identifiers */
    public ?TrackingData $tracking = null;

    /** Link expiration, e.g. "24h", "7d" or an absolute date (default "24h") */
    public string $validUntil = '24h';

    /** Custom redirect URLs (thank-you, fallback, upgrade-error) */
    public ?UrlsData $urls = null;

    /**
     * Product title/description substitutions used on the order form
     *
     * @var array<string, mixed>|null
     */
    public ?array $placeholders = null;

    /** Additional order-form configuration (order form, voucher, payment methods) */
    public ?SettingsData $settings = null;

    /**
     * Additional products offered alongside the main product
     *
     * @var array<int, BuyUrlAddonData>|null
     */
    public ?array $addons = null;

    public function getEndpoint(): string
    {
        return '/createBuyUrl';
    }

    protected function rules(): array
    {
        return [
            'product_id' => [
                'rule' => 'required',
                'message' => 'Product ID is required',
            ],
        ];
    }
}
