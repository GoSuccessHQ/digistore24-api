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
 * Exposes a settable property for every parameter the updateProduct endpoint
 * accepts. Null properties are omitted from the request payload by the base
 * reflection-based toArray().
 *
 * @link https://digistore24.com/api/docs/paths/updateProduct.yaml OpenAPI Specification
 */
final class UpdateProductRequest extends AbstractRequest
{
    /**
     * @param int $productId The Digistore24 product ID
     * @param string|null $nameIntern Internal product name (max 63 chars)
     * @param string|null $nameDe Product name in German (max 63 chars)
     * @param string|null $nameEn Product name in English (max 63 chars)
     * @param string|null $nameEs Product name in Spanish (max 63 chars)
     * @param string|null $descriptionDe Product description in German (filtered HTML)
     * @param string|null $descriptionEn Product description in English (filtered HTML)
     * @param string|null $descriptionEs Product description in Spanish (filtered HTML)
     * @param string|null $descriptionThankyouPageDe German thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPageEn English thank you page description (filtered HTML)
     * @param string|null $descriptionThankyouPageEs Spanish thank you page description (filtered HTML)
     * @param string|null $accessInstructionsDe German access instructions (filtered HTML)
     * @param string|null $accessInstructionsEn English access instructions (filtered HTML)
     * @param string|null $accessInstructionsEs Spanish access instructions (filtered HTML)
     * @param string|null $optinTextDe German opt-in checkbox text
     * @param string|null $optinTextEn English opt-in checkbox text
     * @param string|null $optinTextEs Spanish opt-in checkbox text
     * @param string|null $currency Currency code(s) as comma-separated list (e.g. "USD,EUR")
     * @param string|null $salespageUrl Sales page URL (max 255 chars)
     * @param string|null $upsellSalespageUrl Upsell sales page URL (max 255 chars)
     * @param string|null $thankyouUrl Thank you page URL (max 255 chars)
     * @param string|null $upsellThankyouPageUrl Upsell thank you page URL (max 255 chars)
     * @param string|null $upsellFreeflowThankyouUrl Free upsell flow thank you page URL (max 255 chars)
     * @param int|null $imageId Product image ID
     * @param string|null $imageUrl Product image URL (max 255 chars)
     * @param int|null $productTypeId Product type ID (from getGlobalSettings)
     * @param int|null $productGroupId Product group/folder ID
     * @param int|null $orderformId Order form ID to use
     * @param int|null $socialProofId Social proof bubble ID
     * @param ProductApprovalStatus|null $approvalStatus Product approval status
     * @param string|null $language Language code(s) as comma-separated list (e.g. "en,de")
     * @param string|null $country Country code
     * @param ProductBuyerType|null $buyerType Buyer type (consumer or business)
     * @param string|null $note Internal note
     * @param \DateTimeInterface|null $stopSalesAt Stop sales timestamp
     * @param string|null $supportNoteHtml Support note HTML (network access only)
     * @param bool|null $useCommunity Whether community is enabled
     * @param float|null $communityShare Community share percentage
     * @param float|null $affiliateCommission Affiliate commission percentage
     * @param float|null $affiliateCommissionFix Fixed affiliate commission amount
     * @param string|null $affiliateCommissionCur Currency for fixed commission (max 3 chars)
     * @param bool|null $isAffiliationAutoAccepted Whether affiliations are auto-accepted
     * @param bool|null $isAddressInputMandatory Must buyer enter address
     * @param bool|null $hasAddrSalutation Whether the salutation field is shown
     * @param bool|null $isVatShown Whether VAT is shown
     * @param bool|null $addOrderDataToThankyouPageUrl Add order data to thankyou URL
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
        public int $productId,
        public ?string $nameIntern = null,
        public ?string $nameDe = null,
        public ?string $nameEn = null,
        public ?string $nameEs = null,
        public ?string $descriptionDe = null,
        public ?string $descriptionEn = null,
        public ?string $descriptionEs = null,
        public ?string $descriptionThankyouPageDe = null,
        public ?string $descriptionThankyouPageEn = null,
        public ?string $descriptionThankyouPageEs = null,
        public ?string $accessInstructionsDe = null,
        public ?string $accessInstructionsEn = null,
        public ?string $accessInstructionsEs = null,
        public ?string $optinTextDe = null,
        public ?string $optinTextEn = null,
        public ?string $optinTextEs = null,
        public ?string $currency = null,
        public ?string $salespageUrl = null,
        public ?string $upsellSalespageUrl = null,
        public ?string $thankyouUrl = null,
        public ?string $upsellThankyouPageUrl = null,
        public ?string $upsellFreeflowThankyouUrl = null,
        public ?int $imageId = null,
        public ?string $imageUrl = null,
        public ?int $productTypeId = null,
        public ?int $productGroupId = null,
        public ?int $orderformId = null,
        public ?int $socialProofId = null,
        public ?ProductApprovalStatus $approvalStatus = null,
        public ?string $language = null,
        public ?string $country = null,
        public ?ProductBuyerType $buyerType = null,
        public ?string $note = null,
        public ?\DateTimeInterface $stopSalesAt = null,
        public ?string $supportNoteHtml = null,
        public ?bool $useCommunity = null,
        public ?float $communityShare = null,
        public ?float $affiliateCommission = null,
        public ?float $affiliateCommissionFix = null,
        public ?string $affiliateCommissionCur = null,
        public ?bool $isAffiliationAutoAccepted = null,
        public ?bool $isAddressInputMandatory = null,
        public ?bool $hasAddrSalutation = null,
        public ?bool $isVatShown = null,
        public ?bool $addOrderDataToThankyouPageUrl = null,
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

    public function getEndpoint(): string
    {
        return '/updateProduct';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        // The API expects product_id flat and every other field nested under a
        // `data` object; sent flat the update is silently ignored (modified:N).
        // Verified live.
        $params = parent::toArray();
        unset($params['product_id']);

        return ['product_id' => $this->productId, 'data' => $params];
    }
}
