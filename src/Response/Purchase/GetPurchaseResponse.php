<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\DTO\PurchaseItemData;
use GoSuccess\Digistore24\Api\DTO\PurchaseTransactionData;
use GoSuccess\Digistore24\Api\DTO\RefundPolicyData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Purchase Response
 *
 * Response containing purchase/order details. Mirrors the spec's
 * components/schemas/PurchaseResponse object.
 *
 * @link https://digistore24.com/api/docs/paths/getPurchase.yaml
 */
final class GetPurchaseResponse extends AbstractResponse
{
    public string $result = '';

    /** Purchase ID (spec key: `id`) */
    public string $purchaseId = '';

    /** Purchase amount */
    public float $amount = 0.0;

    /** Currency code */
    public string $currency = 'EUR';

    /** Amount of follow-up payments */
    public ?float $otherAmounts = null;

    /** VAT amount for follow-up payments */
    public ?float $otherVatAmounts = null;

    /** Number of installments (0 for subscriptions) */
    public ?int $numberOfInstallments = null;

    /** Two-letter country code for VAT */
    public ?string $vatCountry = null;

    /** VAT amount */
    public ?float $vatAmount = null;

    /** VAT rate percentage */
    public ?float $vatRate = null;

    /** Purchase creation timestamp */
    public \DateTimeInterface $createdAt;

    /** Type of billing (single_payment, subscription, installment) */
    public ?string $billingType = null;

    /** Billing type in readable form */
    public ?string $billingTypeMsg = null;

    /** Current billing status (paying, completed, aborted, unpaid, reminding) */
    public ?string $billingStatus = null;

    /** Billing status in readable form */
    public ?string $billingStatusMsg = null;

    /** URL to renew payment */
    public ?string $renewUrl = null;

    /** URL to download the receipt */
    public ?string $receiptUrl = null;

    /** URL to download the invoice */
    public ?string $invoiceUrl = null;

    /** Whether the purchase has custom forms (Y/N) */
    public ?bool $hasCustomForms = null;

    /** Whether the purchase has e-tickets (Y/N) */
    public ?bool $hasEtickets = null;

    /** Subscription cancellation policy (e.g. "12m_3m") */
    public ?string $cancelPolicy = null;

    /** Date when cancellation becomes effective */
    public ?string $canCancelBefore = null;

    /** Upsell number indicating the position in the upsell sequence */
    public ?int $upsellNo = null;

    /** Conversion cockpit flow position path (e.g. "ynyynn") */
    public ?string $upsellPosition = null;

    /** Buyer information */
    public ?BuyerData $buyer = null;

    /**
     * Product line items
     *
     * @var array<int, PurchaseItemData>
     */
    public array $items = [];

    /**
     * Payment/refund transactions booked against the order
     *
     * @var array<int, PurchaseTransactionData>
     */
    public array $transactionList = [];

    /** Refund conditions applied to the order */
    public ?RefundPolicyData $refundPolicy = null;

    /**
     * Placeholders used in createBuyUrl
     *
     * @var array<string, mixed>
     */
    public array $placeholders = [];

    /**
     * The complete purchase payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $buyer = is_array($data['buyer'] ?? null) ? $data['buyer'] : null;
        $refundPolicy = is_array($data['refund_policy'] ?? null) ? $data['refund_policy'] : null;
        $placeholders = is_array($data['placeholders'] ?? null) ? $data['placeholders'] : [];

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->purchaseId = TypeConverter::toString($data['id'] ?? '') ?? '';
        $response->amount = TypeConverter::toFloat($data['amount'] ?? 0) ?? 0.0;
        $response->currency = TypeConverter::toString($data['currency'] ?? 'EUR') ?? 'EUR';
        $response->otherAmounts = TypeConverter::toFloat($data['other_amounts'] ?? null);
        $response->otherVatAmounts = TypeConverter::toFloat($data['other_vat_amounts'] ?? null);
        $response->numberOfInstallments = TypeConverter::toInt($data['number_of_installments'] ?? null);
        $response->vatCountry = TypeConverter::toString($data['vat_country'] ?? null);
        $response->vatAmount = TypeConverter::toFloat($data['vat_amount'] ?? null);
        $response->vatRate = TypeConverter::toFloat($data['vat_rate'] ?? null);
        $response->createdAt = TypeConverter::toDateTime($data['created_at'] ?? 'now') ?? new \DateTimeImmutable();
        $response->billingType = TypeConverter::toString($data['billing_type'] ?? null);
        $response->billingTypeMsg = TypeConverter::toString($data['billing_type_msg'] ?? null);
        $response->billingStatus = TypeConverter::toString($data['billing_status'] ?? null);
        $response->billingStatusMsg = TypeConverter::toString($data['billing_status_msg'] ?? null);
        $response->renewUrl = TypeConverter::toString($data['renew_url'] ?? null);
        $response->receiptUrl = TypeConverter::toString($data['receipt_url'] ?? null);
        $response->invoiceUrl = TypeConverter::toString($data['invoice_url'] ?? null);
        $response->hasCustomForms = TypeConverter::toBool($data['has_custom_forms'] ?? null);
        $response->hasEtickets = TypeConverter::toBool($data['has_etickets'] ?? null);
        $response->cancelPolicy = TypeConverter::toString($data['cancel_policy'] ?? null);
        $response->canCancelBefore = TypeConverter::toString($data['can_cancel_before'] ?? null);
        $response->upsellNo = TypeConverter::toInt($data['upsell_no'] ?? null);
        $response->upsellPosition = TypeConverter::toString($data['upsell_position'] ?? null);
        $response->buyer = $buyer !== null ? BuyerData::fromArray(self::toStringKeyedArray($buyer)) : null;
        $response->items = self::buildItems($data['items'] ?? null);
        $response->transactionList = self::buildTransactions($data['transaction_list'] ?? null);
        $response->refundPolicy = $refundPolicy !== null
            ? RefundPolicyData::fromArray(self::toStringKeyedArray($refundPolicy))
            : null;
        $response->placeholders = self::toStringKeyedArray($placeholders);
        $response->data = $data;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @param mixed $items
     * @return array<int, PurchaseItemData>
     */
    private static function buildItems(mixed $items): array
    {
        if (! is_array($items)) {
            return [];
        }

        $result = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                $result[] = PurchaseItemData::fromArray(self::toStringKeyedArray($item));
            }
        }

        return $result;
    }

    /**
     * @param mixed $transactions
     * @return array<int, PurchaseTransactionData>
     */
    private static function buildTransactions(mixed $transactions): array
    {
        if (! is_array($transactions)) {
            return [];
        }

        $result = [];
        foreach ($transactions as $transaction) {
            if (is_array($transaction)) {
                $result[] = PurchaseTransactionData::fromArray(self::toStringKeyedArray($transaction));
            }
        }

        return $result;
    }

    /**
     * @param array<mixed, mixed> $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(array $value): array
    {
        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
