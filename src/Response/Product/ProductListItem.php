<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Product;

use DateTimeInterface;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Product List Item
 *
 * Represents a product with ALL properties from Digistore24 API using Property Hooks (PHP 8.4)
 */
final class ProductListItem
{
    public string $id { get => TypeConverter::toString($this->data['id'], '') ?? ''; }

    public string $name { get => TypeConverter::toString($this->data['name'], '') ?? ''; }

    public string $nameIntern { get => TypeConverter::toString($this->data['name_intern'], '') ?? ''; }

    public string $nameDe { get => TypeConverter::toString($this->data['name_de'], '') ?? ''; }

    public string $nameEn { get => TypeConverter::toString($this->data['name_en'], '') ?? ''; }

    public string $nameFr { get => TypeConverter::toString($this->data['name_fr'], '') ?? ''; }

    public string $nameEs { get => TypeConverter::toString($this->data['name_es'], '') ?? ''; }

    public string $nameNl { get => TypeConverter::toString($this->data['name_nl'], '') ?? ''; }

    public string $nameIt { get => TypeConverter::toString($this->data['name_it'], '') ?? ''; }

    public string $namePt { get => TypeConverter::toString($this->data['name_pt'], '') ?? ''; }

    public string $namePl { get => TypeConverter::toString($this->data['name_pl'], '') ?? ''; }

    public string $nameSl { get => TypeConverter::toString($this->data['name_sl'], '') ?? ''; }

    public string $description { get => TypeConverter::toString($this->data['description'], '') ?? ''; }

    public string $descriptionDe { get => TypeConverter::toString($this->data['description_de'], '') ?? ''; }

    public string $descriptionEn { get => TypeConverter::toString($this->data['description_en'], '') ?? ''; }

    public string $descriptionFr { get => TypeConverter::toString($this->data['description_fr'], '') ?? ''; }

    public string $descriptionEs { get => TypeConverter::toString($this->data['description_es'], '') ?? ''; }

    public string $descriptionNl { get => TypeConverter::toString($this->data['description_nl'], '') ?? ''; }

    public string $descriptionIt { get => TypeConverter::toString($this->data['description_it'], '') ?? ''; }

    public string $descriptionPt { get => TypeConverter::toString($this->data['description_pt'], '') ?? ''; }

    public string $descriptionPl { get => TypeConverter::toString($this->data['description_pl'], '') ?? ''; }

    public string $descriptionSl { get => TypeConverter::toString($this->data['description_sl'], '') ?? ''; }

    public string $descriptionThankyouPage { get => TypeConverter::toString($this->data['description_thankyou_page'], '') ?? ''; }

    public string $descriptionThankyouPageDe { get => TypeConverter::toString($this->data['description_thankyou_page_de'], '') ?? ''; }

    public string $descriptionThankyouPageEn { get => TypeConverter::toString($this->data['description_thankyou_page_en'], '') ?? ''; }

    public string $descriptionThankyouPageFr { get => TypeConverter::toString($this->data['description_thankyou_page_fr'], '') ?? ''; }

    public string $descriptionThankyouPageEs { get => TypeConverter::toString($this->data['description_thankyou_page_es'], '') ?? ''; }

    public string $descriptionThankyouPageNl { get => TypeConverter::toString($this->data['description_thankyou_page_nl'], '') ?? ''; }

    public string $descriptionThankyouPageIt { get => TypeConverter::toString($this->data['description_thankyou_page_it'], '') ?? ''; }

    public string $descriptionThankyouPagePt { get => TypeConverter::toString($this->data['description_thankyou_page_pt'], '') ?? ''; }

    public string $descriptionThankyouPagePl { get => TypeConverter::toString($this->data['description_thankyou_page_pl'], '') ?? ''; }

    public string $descriptionThankyouPageSl { get => TypeConverter::toString($this->data['description_thankyou_page_sl'], '') ?? ''; }

    public string $optinText { get => TypeConverter::toString($this->data['optin_text'], '') ?? ''; }

    public string $optinTextDe { get => TypeConverter::toString($this->data['optin_text_de'], '') ?? ''; }

    public string $optinTextEn { get => TypeConverter::toString($this->data['optin_text_en'], '') ?? ''; }

    public string $optinTextFr { get => TypeConverter::toString($this->data['optin_text_fr'], '') ?? ''; }

    public string $optinTextEs { get => TypeConverter::toString($this->data['optin_text_es'], '') ?? ''; }

    public string $optinTextNl { get => TypeConverter::toString($this->data['optin_text_nl'], '') ?? ''; }

    public string $optinTextIt { get => TypeConverter::toString($this->data['optin_text_it'], '') ?? ''; }

    public string $optinTextPt { get => TypeConverter::toString($this->data['optin_text_pt'], '') ?? ''; }

    public string $optinTextPl { get => TypeConverter::toString($this->data['optin_text_pl'], '') ?? ''; }

    public string $optinTextSl { get => TypeConverter::toString($this->data['optin_text_sl'], '') ?? ''; }

    public string $accessInstructionsDe { get => TypeConverter::toString($this->data['access_instructions_de'], '') ?? ''; }

    public string $accessInstructionsEn { get => TypeConverter::toString($this->data['access_instructions_en'], '') ?? ''; }

    public string $accessInstructionsEs { get => TypeConverter::toString($this->data['access_instructions_es'], '') ?? ''; }

    public string $accessInstructionsFr { get => TypeConverter::toString($this->data['access_instructions_fr'], '') ?? ''; }

    public string $accessInstructionsPt { get => TypeConverter::toString($this->data['access_instructions_pt'], '') ?? ''; }

    public string $accessInstructionsPl { get => TypeConverter::toString($this->data['access_instructions_pl'], '') ?? ''; }

    public string $accessInstructionsIt { get => TypeConverter::toString($this->data['access_instructions_it'], '') ?? ''; }

    public string $accessInstructionsNl { get => TypeConverter::toString($this->data['access_instructions_nl'], '') ?? ''; }

    public string $accessInstructionsSl { get => TypeConverter::toString($this->data['access_instructions_sl'], '') ?? ''; }

    public string $imageUrl { get => TypeConverter::toString($this->data['image_url'], '') ?? ''; }

    public string $imageId { get => TypeConverter::toString($this->data['image_id'], '') ?? ''; }

    public int $userId { get => TypeConverter::toInt($this->data['user_id'], 0) ?? 0; }

    public int $ownerId { get => TypeConverter::toInt($this->data['owner_id'], 0) ?? 0; }

    public string $ownerName { get => TypeConverter::toString($this->data['owner_name'], '') ?? ''; }

    public int $productGroupId { get => TypeConverter::toInt($this->data['product_group_id'], 0) ?? 0; }

    public string $productGroupName { get => TypeConverter::toString($this->data['product_group_name'], '') ?? ''; }

    public int $productTypeId { get => TypeConverter::toInt($this->data['product_type_id'], 0) ?? 0; }

    public bool $isActive { get => TypeConverter::toBool($this->data['is_active'], false) ?? false; }

    public bool $isDeleted { get => TypeConverter::toBool($this->data['is_deleted'], false) ?? false; }

    public bool $isAddressInputMandatory { get => TypeConverter::toBool($this->data['is_address_input_mandatory'], false) ?? false; }

    public bool $isPhoneNoMandatory { get => TypeConverter::toBool($this->data['is_phone_no_mandatory'], false) ?? false; }

    public bool $isSearchEngineAllowed { get => TypeConverter::toBool($this->data['is_search_engine_allowed'], false) ?? false; }

    public bool $isAffiliationAutoAccepted { get => TypeConverter::toBool($this->data['is_affiliation_auto_accepted'], false) ?? false; }

    public bool $isFreeUpsellEnabled { get => TypeConverter::toBool($this->data['is_free_upsell_enabled'], false) ?? false; }

    public bool $isFreeUpsellStarted { get => TypeConverter::toBool($this->data['is_free_upsell_started'], false) ?? false; }

    public bool $isFreeUpsellStopped { get => TypeConverter::toBool($this->data['is_free_upsell_stopped'], false) ?? false; }

    public bool $isQuantityEditableAfterPurchase { get => TypeConverter::toBool($this->data['is_quantity_editable_after_purchase'], false) ?? false; }

    public bool $isTitleInputShown { get => TypeConverter::toBool($this->data['is_title_input_shown'], false) ?? false; }

    public bool $isNameShownOnBankStatement { get => TypeConverter::toBool($this->data['is_name_shown_on_bank_statement'], false) ?? false; }

    public bool $hasAddrSalutation { get => TypeConverter::toBool($this->data['has_addr_salutation'], false) ?? false; }

    public bool $isVatShown { get => TypeConverter::toBool($this->data['is_vat_shown'], false) ?? false; }

    public bool $isUpsellDoublePurchasePrevented { get => TypeConverter::toBool($this->data['is_upsell_double_purchase_prevented'], false) ?? false; }

    public bool $isOptinCheckboxShown { get => TypeConverter::toBool($this->data['is_optin_checkbox_shown'], false) ?? false; }

    public bool $addOrderDataToThankyouPageUrl { get => TypeConverter::toBool($this->data['add_order_data_to_thankyou_page_url'], false) ?? false; }

    public bool $addOrderDataToUpsellSalesPageUrl { get => TypeConverter::toBool($this->data['add_order_data_to_upsell_sales_page_url'], false) ?? false; }

    public bool $redirectToCustomUpsellThankyouPage { get => TypeConverter::toBool($this->data['redirect_to_custom_upsell_thankyou_page'], false) ?? false; }

    public bool $addOrderDataToUpsellThankyouPageUrl { get => TypeConverter::toBool($this->data['add_order_data_to_upsell_thankyou_page_url'], false) ?? false; }

    public string $isPhoneNoInputShown { get => TypeConverter::toString($this->data['is_phone_no_input_shown'], 'hidden') ?? 'hidden'; }

    public string $isQuantityEditableBeforePurchase { get => TypeConverter::toString($this->data['is_quantity_editable_before_purchase'], '') ?? ''; }

    public string $currency { get => TypeConverter::toString($this->data['currency'], 'EUR') ?? 'EUR'; }

    public string $affiliateCommission { get => TypeConverter::toString($this->data['affiliate_commission'], '0.00') ?? '0.00'; }

    public string $affiliateCommissionFix { get => TypeConverter::toString($this->data['affiliate_commission_fix'], '0.00') ?? '0.00'; }

    public string $affiliateCommissionCur { get => TypeConverter::toString($this->data['affiliate_commission_cur'], 'EUR') ?? 'EUR'; }

    public string $salespageUrl { get => TypeConverter::toString($this->data['salespage_url'], '') ?? ''; }

    public string $orderformCustomerUrl { get => TypeConverter::toString($this->data['orderform_customer_url'], '') ?? ''; }

    public string $orderformPreviewUrl { get => TypeConverter::toString($this->data['orderform_preview_url'], '') ?? ''; }

    public string $thankyouUrl { get => TypeConverter::toString($this->data['thankyou_url'], '') ?? ''; }

    public string $upsellSalespageUrl { get => TypeConverter::toString($this->data['upsell_salespage_url'], '') ?? ''; }

    public string $upsellThankyouPageUrl { get => TypeConverter::toString($this->data['upsell_thankyou_page_url'], '') ?? ''; }

    public string $upsellFreeflowThankyouUrl { get => TypeConverter::toString($this->data['upsell_freeflow_thankyou_url'], '') ?? ''; }

    public string $language { get => TypeConverter::toString($this->data['language'], 'de') ?? 'de'; }

    public string $country { get => TypeConverter::toString($this->data['country'], '') ?? ''; }

    public string $buyerType { get => TypeConverter::toString($this->data['buyer_type'], '') ?? ''; }

    public string $tag { get => TypeConverter::toString($this->data['tag'], '') ?? ''; }

    public string $note { get => TypeConverter::toString($this->data['note'], '') ?? ''; }

    public string $orderformId { get => TypeConverter::toString($this->data['orderform_id'], '') ?? ''; }

    public string $unitsLeft { get => TypeConverter::toString($this->data['units_left'], '') ?? ''; }

    public string $maxQuantity { get => TypeConverter::toString($this->data['max_quantity'], '') ?? ''; }

    public string $payMethods { get => TypeConverter::toString($this->data['pay_methods'], '') ?? ''; }

    public string $serviceInterval { get => TypeConverter::toString($this->data['service_interval'], 'auto') ?? 'auto'; }

    public string $serviceDate { get => TypeConverter::toString($this->data['service_date'], '') ?? ''; }

    public string $singlePaymentServicePeriod { get => TypeConverter::toString($this->data['single_payment_service_period'], '') ?? ''; }

    public string $encryptOrderDataOfThankyouPageUrl { get => TypeConverter::toString($this->data['encrypt_order_data_of_thankyou_page_url'], 'none') ?? 'none'; }

    public string $encryptOrderDataOfUpsellThankyouPageUrl { get => TypeConverter::toString($this->data['encrypt_order_data_of_upsell_thankyou_page_url'], 'none') ?? 'none'; }

    public string $notifyPaymentEmails { get => TypeConverter::toString($this->data['notify_payment_emails'], '') ?? ''; }

    public string $notifyRefundEmails { get => TypeConverter::toString($this->data['notify_refund_emails'], '') ?? ''; }

    public string $notifyChargebackEmails { get => TypeConverter::toString($this->data['notify_chargeback_emails'], '') ?? ''; }

    public string $notifyMissedPaymentEmails { get => TypeConverter::toString($this->data['notify_missed_payment_emails'], '') ?? ''; }

    public string $notifyRebillingStartStopEmails { get => TypeConverter::toString($this->data['notify_rebilling_start_stop_emails'], '') ?? ''; }

    public string $notifyRebillingPaymentEmails { get => TypeConverter::toString($this->data['notify_rebilling_payment_emails'], '') ?? ''; }

    public string $notifyAffiliateEmails { get => TypeConverter::toString($this->data['notify_affiliate_emails'], '') ?? ''; }

    public string $notifyAddonsFor { get => TypeConverter::toString($this->data['notify_addons_for'], '') ?? ''; }

    public ?DateTimeInterface $createdAt { get => TypeConverter::toDateTime($this->data['created_at'] ?? null); }

    public ?DateTimeInterface $modifiedAt { get => TypeConverter::toDateTime($this->data['modified_at'] ?? null); }

    public ?string $stopSalesAt { get => ! empty($this->data['stop_sales_at']) ? TypeConverter::toString($this->data['stop_sales_at']) : null; }

    /** @var array<int|string, mixed> */
    public array $approvalStatusList { get => TypeConverter::toArray($this->data['approval_status_list'], []) ?? []; }

    public string $approvalStatus { get => TypeConverter::toString($this->data['approval_status'], '') ?? ''; }

    public string $approvalStatusMsg { get => TypeConverter::toString($this->data['approval_status_msg'], '') ?? ''; }

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Raw data from API response
     */
    public function __construct(
        private readonly array $data,
    ) {
    }

    /**
     * Create instance from array data
     *
     * @param array<string, mixed> $data Raw data from API response
     * @param Response|null $rawResponse Optional raw HTTP response
     * @return static
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        return new self($data);
    }
}
