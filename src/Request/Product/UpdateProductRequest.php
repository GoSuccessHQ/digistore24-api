<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Product;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\AffiliateApprovalStatus;
use GoSuccess\Digistore24\Api\Enum\BuyerType;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

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
     * @param AffiliateApprovalStatus|null $approvalStatus Approval status
     * @param float|null $affiliateCommission Commission for affiliates
     * @param BuyerType|null $buyerType Buyer type (business, consumer, common, vendor)
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
        public ?AffiliateApprovalStatus $approvalStatus = null,
        public ?float $affiliateCommission = null,
        public ?BuyerType $buyerType = null,
        public ?bool $isAddressInputMandatory = null,
        public ?bool $addOrderDataToThankyouPageUrl = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'product_id' => $this->productId,
        ];

        if ($this->nameDe !== null) {
            $data['name_de'] = $this->nameDe;
        }
        if ($this->nameEn !== null) {
            $data['name_en'] = $this->nameEn;
        }
        if ($this->nameEs !== null) {
            $data['name_es'] = $this->nameEs;
        }
        if ($this->nameIntern !== null) {
            $data['name_intern'] = $this->nameIntern;
        }
        if ($this->descriptionDe !== null) {
            $data['description_de'] = $this->descriptionDe;
        }
        if ($this->descriptionEn !== null) {
            $data['description_en'] = $this->descriptionEn;
        }
        if ($this->descriptionEs !== null) {
            $data['description_es'] = $this->descriptionEs;
        }
        if ($this->salespageUrl !== null) {
            $data['salespage_url'] = $this->salespageUrl;
        }
        if ($this->upsellSalespageUrl !== null) {
            $data['upsell_salespage_url'] = $this->upsellSalespageUrl;
        }
        if ($this->thankyouUrl !== null) {
            $data['thankyou_url'] = $this->thankyouUrl;
        }
        if ($this->imageUrl !== null) {
            $data['image_url'] = $this->imageUrl;
        }
        if ($this->productTypeId !== null) {
            $data['product_type_id'] = $this->productTypeId;
        }
        if ($this->currency !== null) {
            $data['currency'] = $this->currency;
        }
        if ($this->approvalStatus !== null) {
            $data['approval_status'] = $this->approvalStatus->value;
        }
        if ($this->affiliateCommission !== null) {
            $data['affiliate_commission'] = $this->affiliateCommission;
        }
        if ($this->buyerType !== null) {
            $data['buyer_type'] = $this->buyerType->value;
        }
        if ($this->isAddressInputMandatory !== null) {
            $data['is_address_input_mandatory'] = TypeConverter::fromBool($this->isAddressInputMandatory);
        }
        if ($this->addOrderDataToThankyouPageUrl !== null) {
            $data['add_order_data_to_thankyou_page_url'] = TypeConverter::fromBool($this->addOrderDataToThankyouPageUrl);
        }

        return $data;
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
