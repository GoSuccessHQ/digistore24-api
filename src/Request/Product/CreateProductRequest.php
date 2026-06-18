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
     * @param string|null $nameFr French product name (max 63 chars)
     * @param string|null $namePt Portuguese product name (max 63 chars)
     * @param string|null $namePl Polish product name (max 63 chars)
     * @param string|null $nameIt Italian product name (max 63 chars)
     * @param string|null $nameNl Dutch product name (max 63 chars)
     * @param string|null $nameSl Slovenian product name (max 63 chars)
     * @param string|null $descriptionDe German description (filtered HTML)
     * @param string|null $descriptionEn English description (filtered HTML)
     * @param string|null $descriptionEs Spanish description (filtered HTML)
     * @param string|null $descriptionFr French description (filtered HTML)
     * @param string|null $descriptionPt Portuguese description (filtered HTML)
     * @param string|null $descriptionPl Polish description (filtered HTML)
     * @param string|null $descriptionIt Italian description (filtered HTML)
     * @param string|null $descriptionNl Dutch description (filtered HTML)
     * @param string|null $descriptionSl Slovenian description (filtered HTML)
     * @param string|null $salespageUrl Sales page URL (max 255 chars)
     * @param string|null $upsellSalespageUrl Upsell sales page URL (max 255 chars)
     * @param string|null $thankyouUrl Thank you page URL (max 255 chars)
     * @param string|null $imageUrl Product image URL (max 255 chars)
     * @param int|null $productTypeId Product type ID (from getGlobalSettings)
     * @param ProductApprovalStatus|null $approvalStatus Product approval status
     * @param float|null $affiliateCommission Affiliate commission percentage
     * @param ProductBuyerType|null $buyerType Buyer type (consumer or business)
     * @param bool|null $isAddressInputMandatory Must buyer enter address
     * @param bool|null $addOrderDataToThankyouPageUrl Add order data to thankyou URL
     * @param string|null $descriptionThankyouPageDe German thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPageEn English thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPageEs Spanish thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPageFr French thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPagePt Portuguese thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPagePl Polish thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPageIt Italian thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPageNl Dutch thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPageSl Slovenian thank you page description (filtered HTML)
     * @param string|null $accessInstructionsDe German access instructions (filtered HTML)
     * @param string|null $accessInstructionsEn English access instructions (filtered HTML)
     * @param string|null $accessInstructionsEs Spanish access instructions (filtered HTML)
     * @param string|null $accessInstructionsFr French access instructions (filtered HTML)
     * @param string|null $accessInstructionsPt Portuguese access instructions (filtered HTML)
     * @param string|null $accessInstructionsPl Polish access instructions (filtered HTML)
     * @param string|null $accessInstructionsIt Italian access instructions (filtered HTML)
     * @param string|null $accessInstructionsNl Dutch access instructions (filtered HTML)
     * @param string|null $accessInstructionsSl Slovenian access instructions (filtered HTML)
     * @param string|null $optinTextDe German opt-in checkbox text
     * @param string|null $optinTextEn English opt-in checkbox text
     * @param string|null $optinTextEs Spanish opt-in checkbox text
     * @param string|null $optinTextFr French opt-in checkbox text
     * @param string|null $optinTextPt Portuguese opt-in checkbox text
     * @param string|null $optinTextPl Polish opt-in checkbox text
     * @param string|null $optinTextIt Italian opt-in checkbox text
     * @param string|null $optinTextNl Dutch opt-in checkbox text
     * @param string|null $optinTextSl Slovenian opt-in checkbox text
     * @param string|null $currency Currency code(s) as comma-separated list (e.g. "USD,EUR")
     * @param string|null $upsellThankyouPageUrl Upsell thank you page URL (max 255 chars)
     * @param string|null $upsellFreeflowThankyouUrl Free upsell flow thank you page URL (max 255 chars)
     * @param int|null $imageId Product image ID
     * @param int|null $productGroupId Product group/folder ID
     * @param int|null $orderformId Order form ID to use
     * @param int|null $socialProofId Social proof bubble ID
     * @param string|null $language Language code(s) as comma-separated list (e.g. "en,de")
     * @param string|null $country Country code
     * @param string|null $note Internal note
     * @param \DateTimeInterface|null $stopSalesAt Stop sales timestamp
     * @param string|null $supportNoteHtml Support note HTML (network access only)
     * @param bool|null $useCommunity Whether community is enabled
     * @param float|null $communityShare Community share percentage
     * @param float|null $affiliateCommissionFix Fixed affiliate commission amount
     * @param string|null $affiliateCommissionCur Currency for fixed commission (max 3 chars)
     * @param bool|null $isAffiliationAutoAccepted Whether affiliations are auto-accepted
     * @param bool|null $hasAddrSalutation Whether the salutation field is shown
     * @param bool|null $isVatShown Whether VAT is shown
     * @param bool|null $addOrderDataToUpsellSalesPageUrl Add order data to upsell sales page URL
     * @param string|null $addOrderDataToUpsellThankyouPageUrl Policy for upsell thank you order data
     * @param string|null $redirectToCustomUpsellThankyouPage Policy for custom upsell thank you redirect
     * @param string|null $encryptOrderDataOfThankyouPageUrl Encryption option for thank you data
     * @param string|null $encryptOrderDataOfUpsellThankyouPageUrl Encryption option for upsell thank you data
     * @param bool|null $isAddonThankyouUrlEnabled Whether addon thank you URL is enabled
     * @param bool|null $isFreeUpsellStarted Whether free upsell is started
     * @param bool|null $isFreeUpsellEnabled Whether free upsell is enabled
     * @param bool|null $isFreeUpsellStopped Whether free upsell is stopped
     * @param bool|null $isUpsellDoublePurchasePrevented Whether double upsell purchase is prevented
     * @param bool|null $isOptinCheckboxShown Whether the opt-in checkbox is shown
     * @param int|null $maxQuantity Maximum purchasable quantity
     * @param int|null $defaultQuantity Default pre-selected quantity
     * @param bool|null $isPhoneNoInputShown Whether the phone number input is shown
     * @param bool|null $isPhoneNoMandatory Whether the phone number is mandatory
     * @param bool|null $isTitleInputShown Whether the title input is shown
     * @param bool|null $isNameShownOnBankStatement Whether the name is shown on bank statements
     * @param bool|null $isSearchEngineAllowed Whether search engines are allowed
     * @param bool|null $doAskForCompanyByDefault Whether the company field is asked by default
     * @param bool|null $isVoucherInputHidden Whether the voucher input is hidden
     * @param string|null $payMethods Comma-separated payment method list
     * @param string|null $notifyPaymentEmails Comma-separated email addresses
     * @param string|null $notifyRefundEmails Comma-separated email addresses
     * @param string|null $notifyChargebackEmails Comma-separated email addresses
     * @param string|null $notifyMissedPaymentEmails Comma-separated email addresses
     * @param string|null $notifyRebillingStartStopEmails Comma-separated email addresses
     * @param string|null $notifyRebillingPaymentEmails Comma-separated email addresses
     * @param string|null $notifyAffiliateEmails Comma-separated email addresses
     * @param string|null $notifyAddonsFor Addon notification policy
     * @param string|null $serviceInterval Service interval type
     * @param string|null $serviceDate Service date
     * @param bool|null $isActive Whether the product is active
     */
    public function __construct(
        public string $nameIntern,
        public ?string $nameDe = null,
        public ?string $nameEn = null,
        public ?string $nameEs = null,
        public ?string $nameFr = null,
        public ?string $namePt = null,
        public ?string $namePl = null,
        public ?string $nameIt = null,
        public ?string $nameNl = null,
        public ?string $nameSl = null,
        public ?string $descriptionDe = null,
        public ?string $descriptionEn = null,
        public ?string $descriptionEs = null,
        public ?string $descriptionFr = null,
        public ?string $descriptionPt = null,
        public ?string $descriptionPl = null,
        public ?string $descriptionIt = null,
        public ?string $descriptionNl = null,
        public ?string $descriptionSl = null,
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
        public ?string $descriptionThankyouPageDe = null,
        public ?string $descriptionThankyouPageEn = null,
        public ?string $descriptionThankyouPageEs = null,
        public ?string $descriptionThankyouPageFr = null,
        public ?string $descriptionThankyouPagePt = null,
        public ?string $descriptionThankyouPagePl = null,
        public ?string $descriptionThankyouPageIt = null,
        public ?string $descriptionThankyouPageNl = null,
        public ?string $descriptionThankyouPageSl = null,
        public ?string $accessInstructionsDe = null,
        public ?string $accessInstructionsEn = null,
        public ?string $accessInstructionsEs = null,
        public ?string $accessInstructionsFr = null,
        public ?string $accessInstructionsPt = null,
        public ?string $accessInstructionsPl = null,
        public ?string $accessInstructionsIt = null,
        public ?string $accessInstructionsNl = null,
        public ?string $accessInstructionsSl = null,
        public ?string $optinTextDe = null,
        public ?string $optinTextEn = null,
        public ?string $optinTextEs = null,
        public ?string $optinTextFr = null,
        public ?string $optinTextPt = null,
        public ?string $optinTextPl = null,
        public ?string $optinTextIt = null,
        public ?string $optinTextNl = null,
        public ?string $optinTextSl = null,
        public ?string $currency = null,
        public ?string $upsellThankyouPageUrl = null,
        public ?string $upsellFreeflowThankyouUrl = null,
        public ?int $imageId = null,
        public ?int $productGroupId = null,
        public ?int $orderformId = null,
        public ?int $socialProofId = null,
        public ?string $language = null,
        public ?string $country = null,
        public ?string $note = null,
        public ?\DateTimeInterface $stopSalesAt = null,
        public ?string $supportNoteHtml = null,
        public ?bool $useCommunity = null,
        public ?float $communityShare = null,
        public ?float $affiliateCommissionFix = null,
        public ?string $affiliateCommissionCur = null,
        public ?bool $isAffiliationAutoAccepted = null,
        public ?bool $hasAddrSalutation = null,
        public ?bool $isVatShown = null,
        public ?bool $addOrderDataToUpsellSalesPageUrl = null,
        public ?string $addOrderDataToUpsellThankyouPageUrl = null,
        public ?string $redirectToCustomUpsellThankyouPage = null,
        public ?string $encryptOrderDataOfThankyouPageUrl = null,
        public ?string $encryptOrderDataOfUpsellThankyouPageUrl = null,
        public ?bool $isAddonThankyouUrlEnabled = null,
        public ?bool $isFreeUpsellStarted = null,
        public ?bool $isFreeUpsellEnabled = null,
        public ?bool $isFreeUpsellStopped = null,
        public ?bool $isUpsellDoublePurchasePrevented = null,
        public ?bool $isOptinCheckboxShown = null,
        public ?int $maxQuantity = null,
        public ?int $defaultQuantity = null,
        public ?bool $isPhoneNoInputShown = null,
        public ?bool $isPhoneNoMandatory = null,
        public ?bool $isTitleInputShown = null,
        public ?bool $isNameShownOnBankStatement = null,
        public ?bool $isSearchEngineAllowed = null,
        public ?bool $doAskForCompanyByDefault = null,
        public ?bool $isVoucherInputHidden = null,
        public ?string $payMethods = null,
        public ?string $notifyPaymentEmails = null,
        public ?string $notifyRefundEmails = null,
        public ?string $notifyChargebackEmails = null,
        public ?string $notifyMissedPaymentEmails = null,
        public ?string $notifyRebillingStartStopEmails = null,
        public ?string $notifyRebillingPaymentEmails = null,
        public ?string $notifyAffiliateEmails = null,
        public ?string $notifyAddonsFor = null,
        public ?string $serviceInterval = null,
        public ?string $serviceDate = null,
        public ?bool $isActive = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'name_intern' => $this->nameIntern,
        ];

        foreach ($this->stringFields() as $key => $value) {
            if ($value !== null) {
                $data[$key] = $value;
            }
        }

        foreach ($this->intFields() as $key => $value) {
            if ($value !== null) {
                $data[$key] = $value;
            }
        }

        foreach ($this->floatFields() as $key => $value) {
            if ($value !== null) {
                $data[$key] = $value;
            }
        }

        foreach ($this->boolFields() as $key => $value) {
            if ($value !== null) {
                $data[$key] = TypeConverter::fromBool($value);
            }
        }

        if ($this->approvalStatus !== null) {
            $data['approval_status'] = $this->approvalStatus->value;
        }
        if ($this->buyerType !== null) {
            $data['buyer_type'] = $this->buyerType->value;
        }
        if ($this->stopSalesAt !== null) {
            $data['stop_sales_at'] = $this->stopSalesAt->format('Y-m-d H:i:s');
        }

        return ['data' => $data];
    }

    /**
     * @return array<string, string|null>
     */
    private function stringFields(): array
    {
        return [
            'name_de' => $this->nameDe,
            'name_en' => $this->nameEn,
            'name_es' => $this->nameEs,
            'name_fr' => $this->nameFr,
            'name_pt' => $this->namePt,
            'name_pl' => $this->namePl,
            'name_it' => $this->nameIt,
            'name_nl' => $this->nameNl,
            'name_sl' => $this->nameSl,
            'description_de' => $this->descriptionDe,
            'description_en' => $this->descriptionEn,
            'description_es' => $this->descriptionEs,
            'description_fr' => $this->descriptionFr,
            'description_pt' => $this->descriptionPt,
            'description_pl' => $this->descriptionPl,
            'description_it' => $this->descriptionIt,
            'description_nl' => $this->descriptionNl,
            'description_sl' => $this->descriptionSl,
            'description_thankyou_page_de' => $this->descriptionThankyouPageDe,
            'description_thankyou_page_en' => $this->descriptionThankyouPageEn,
            'description_thankyou_page_es' => $this->descriptionThankyouPageEs,
            'description_thankyou_page_fr' => $this->descriptionThankyouPageFr,
            'description_thankyou_page_pt' => $this->descriptionThankyouPagePt,
            'description_thankyou_page_pl' => $this->descriptionThankyouPagePl,
            'description_thankyou_page_it' => $this->descriptionThankyouPageIt,
            'description_thankyou_page_nl' => $this->descriptionThankyouPageNl,
            'description_thankyou_page_sl' => $this->descriptionThankyouPageSl,
            'access_instructions_de' => $this->accessInstructionsDe,
            'access_instructions_en' => $this->accessInstructionsEn,
            'access_instructions_es' => $this->accessInstructionsEs,
            'access_instructions_fr' => $this->accessInstructionsFr,
            'access_instructions_pt' => $this->accessInstructionsPt,
            'access_instructions_pl' => $this->accessInstructionsPl,
            'access_instructions_it' => $this->accessInstructionsIt,
            'access_instructions_nl' => $this->accessInstructionsNl,
            'access_instructions_sl' => $this->accessInstructionsSl,
            'optin_text_de' => $this->optinTextDe,
            'optin_text_en' => $this->optinTextEn,
            'optin_text_es' => $this->optinTextEs,
            'optin_text_fr' => $this->optinTextFr,
            'optin_text_pt' => $this->optinTextPt,
            'optin_text_pl' => $this->optinTextPl,
            'optin_text_it' => $this->optinTextIt,
            'optin_text_nl' => $this->optinTextNl,
            'optin_text_sl' => $this->optinTextSl,
            'currency' => $this->currency,
            'salespage_url' => $this->salespageUrl,
            'upsell_salespage_url' => $this->upsellSalespageUrl,
            'thankyou_url' => $this->thankyouUrl,
            'upsell_thankyou_page_url' => $this->upsellThankyouPageUrl,
            'upsell_freeflow_thankyou_url' => $this->upsellFreeflowThankyouUrl,
            'image_url' => $this->imageUrl,
            'language' => $this->language,
            'country' => $this->country,
            'note' => $this->note,
            'support_note_html' => $this->supportNoteHtml,
            'affiliate_commission_cur' => $this->affiliateCommissionCur,
            'add_order_data_to_upsell_thankyou_page_url' => $this->addOrderDataToUpsellThankyouPageUrl,
            'redirect_to_custom_upsell_thankyou_page' => $this->redirectToCustomUpsellThankyouPage,
            'encrypt_order_data_of_thankyou_page_url' => $this->encryptOrderDataOfThankyouPageUrl,
            'encrypt_order_data_of_upsell_thankyou_page_url' => $this->encryptOrderDataOfUpsellThankyouPageUrl,
            'pay_methods' => $this->payMethods,
            'notify_payment_emails' => $this->notifyPaymentEmails,
            'notify_refund_emails' => $this->notifyRefundEmails,
            'notify_chargeback_emails' => $this->notifyChargebackEmails,
            'notify_missed_payment_emails' => $this->notifyMissedPaymentEmails,
            'notify_rebilling_start_stop_emails' => $this->notifyRebillingStartStopEmails,
            'notify_rebilling_payment_emails' => $this->notifyRebillingPaymentEmails,
            'notify_affiliate_emails' => $this->notifyAffiliateEmails,
            'notify_addons_for' => $this->notifyAddonsFor,
            'service_interval' => $this->serviceInterval,
            'service_date' => $this->serviceDate,
        ];
    }

    /**
     * @return array<string, int|null>
     */
    private function intFields(): array
    {
        return [
            'image_id' => $this->imageId,
            'product_type_id' => $this->productTypeId,
            'product_group_id' => $this->productGroupId,
            'orderform_id' => $this->orderformId,
            'social_proof_id' => $this->socialProofId,
            'max_quantity' => $this->maxQuantity,
            'default_quantity' => $this->defaultQuantity,
        ];
    }

    /**
     * @return array<string, float|null>
     */
    private function floatFields(): array
    {
        return [
            'community_share' => $this->communityShare,
            'affiliate_commission' => $this->affiliateCommission,
            'affiliate_commission_fix' => $this->affiliateCommissionFix,
        ];
    }

    /**
     * @return array<string, bool|null>
     */
    private function boolFields(): array
    {
        return [
            'use_community' => $this->useCommunity,
            'is_affiliation_auto_accepted' => $this->isAffiliationAutoAccepted,
            'is_address_input_mandatory' => $this->isAddressInputMandatory,
            'has_addr_salutation' => $this->hasAddrSalutation,
            'is_vat_shown' => $this->isVatShown,
            'add_order_data_to_thankyou_page_url' => $this->addOrderDataToThankyouPageUrl,
            'add_order_data_to_upsell_sales_page_url' => $this->addOrderDataToUpsellSalesPageUrl,
            'is_addon_thankyou_url_enabled' => $this->isAddonThankyouUrlEnabled,
            'is_free_upsell_started' => $this->isFreeUpsellStarted,
            'is_free_upsell_enabled' => $this->isFreeUpsellEnabled,
            'is_free_upsell_stopped' => $this->isFreeUpsellStopped,
            'is_upsell_double_purchase_prevented' => $this->isUpsellDoublePurchasePrevented,
            'is_optin_checkbox_shown' => $this->isOptinCheckboxShown,
            'is_phone_no_input_shown' => $this->isPhoneNoInputShown,
            'is_phone_no_mandatory' => $this->isPhoneNoMandatory,
            'is_title_input_shown' => $this->isTitleInputShown,
            'is_name_shown_on_bank_statement' => $this->isNameShownOnBankStatement,
            'is_search_engine_allowed' => $this->isSearchEngineAllowed,
            'do_ask_for_company_by_default' => $this->doAskForCompanyByDefault,
            'is_voucher_input_hidden' => $this->isVoucherInputHidden,
            'is_active' => $this->isActive,
        ];
    }

    public function getEndpoint(): string
    {
        return '/createProduct';
    }
}
