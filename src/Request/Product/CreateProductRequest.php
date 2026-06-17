<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Product;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\ProductApprovalStatus;
use GoSuccess\Digistore24\Api\Enum\ProductBuyerType;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Request to create a new product
 *
 * @link https://digistore24.com/api/docs/paths/createProduct.yaml OpenAPI Specification
 */
final class CreateProductRequest extends AbstractRequest
{
    /**
     * @param string $nameIntern Internal product name (max 63 chars)
     * @param string|null $nameDe German product name (max 63 chars)
     * @param string|null $nameEn English product name (max 63 chars)
     * @param string|null $nameEs Spanish product name (max 63 chars)
     * @param string|null $descriptionDe German description (filtered HTML)
     * @param string|null $descriptionEn English description (filtered HTML)
     * @param string|null $descriptionEs Spanish description (filtered HTML)
     * @param string|null $salespageUrl Sales page URL (max 255 chars)
     * @param string|null $upsellSalespageUrl Upsell sales page URL (max 255 chars)
     * @param string|null $thankyouUrl Thank you page URL (max 255 chars)
     * @param string|null $imageUrl Product image URL (max 255 chars)
     * @param int|null $productTypeId Product type ID (from getGlobalSettings)
     * @param ProductApprovalStatus|null $approvalStatus Product approval status
     * @param float|null $affiliateCommission Affiliate commission amount
     * @param ProductBuyerType|null $buyerType Buyer type (consumer or business)
     * @param bool|null $isAddressInputMandatory Must buyer enter address
     * @param bool|null $addOrderDataToThankyouPageUrl Add order data to thankyou URL
     */
    public function __construct(
        public string $nameIntern,
        public ?string $nameDe = null,
        public ?string $nameEn = null,
        public ?string $nameEs = null,
        public ?string $descriptionDe = null,
        public ?string $descriptionEn = null,
        public ?string $descriptionEs = null,
        public ?string $salespageUrl = null,
        public ?string $upsellSalespageUrl = null,
        public ?string $thankyouUrl = null,
        public ?string $imageUrl = null,
        public ?int $productTypeId = null,
        public ?ProductApprovalStatus $approvalStatus = null,
        public ?float $affiliateCommission = null,
        public ?ProductBuyerType $buyerType = null,
        public ?bool $isAddressInputMandatory = null,
        public ?bool $addOrderDataToThankyouPageUrl = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'name_intern' => $this->nameIntern,
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

        return ['data' => $data];
    }

    public function getEndpoint(): string
    {
        return '/createProduct';
    }
}
