<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Product;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Enum\ProductApprovalStatus;
use GoSuccess\Digistore24\Api\Enum\ProductBuyerType;

/**
 * Request to update an existing product
 *
 * @link https://digistore24.com/api/docs/paths/updateProduct.yaml OpenAPI Specification
 */
final class UpdateProductRequest extends AbstractRequest
{
    /**
     * @param int $productId The Digistore24 product ID
     * @param string|null $nameDe Product name in German (max 63 chars)
     * @param string|null $nameEn Product name in English (max 63 chars)
     * @param string|null $nameEs Product name in Spanish (max 63 chars)
     * @param string|null $nameIntern Internal product name (max 63 chars)
     * @param string|null $descriptionDe Product description in German (filtered HTML)
     * @param string|null $descriptionEn Product description in English (filtered HTML)
     * @param string|null $descriptionEs Product description in Spanish (filtered HTML)
     * @param string|null $salespageUrl URL of the sales page (max 255 chars)
     * @param string|null $upsellSalespageUrl URL of the upsell sales page (max 255 chars)
     * @param string|null $thankyouUrl URL of the thank you page (max 255 chars)
     * @param string|null $imageUrl URL of the product image (max 255 chars)
     * @param int|null $productTypeId Product type ID (from getGlobalSettings)
     * @param string|null $currency List of possible currencies (e.g., "USD,EUR")
     * @param ProductApprovalStatus|null $approvalStatus Approval status
     * @param float|null $affiliateCommission Commission for affiliates
     * @param ProductBuyerType|null $buyerType Buyer type (consumer or business)
     * @param bool|null $isAddressInputMandatory True if buyer must always enter address
     * @param bool|null $addOrderDataToThankyouPageUrl True if order data is added to thankyou URL
     */
    public function __construct(
        public int $productId,
        public ?string $nameDe = null,
        public ?string $nameEn = null,
        public ?string $nameEs = null,
        public ?string $nameIntern = null,
        public ?string $descriptionDe = null,
        public ?string $descriptionEn = null,
        public ?string $descriptionEs = null,
        public ?string $salespageUrl = null,
        public ?string $upsellSalespageUrl = null,
        public ?string $thankyouUrl = null,
        public ?string $imageUrl = null,
        public ?int $productTypeId = null,
        public ?string $currency = null,
        public ?ProductApprovalStatus $approvalStatus = null,
        public ?float $affiliateCommission = null,
        public ?ProductBuyerType $buyerType = null,
        public ?bool $isAddressInputMandatory = null,
        public ?bool $addOrderDataToThankyouPageUrl = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/updateProduct';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }
}
