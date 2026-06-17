<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Purchase Response
 *
 * Response containing purchase/order details.
 */
final class GetPurchaseResponse extends AbstractResponse
{
    public string $result = '';

    public string $purchaseId = '';

    public string $productId = '';

    public string $productName = '';

    public string $buyerEmail = '';

    public string $paymentStatus = '';

    public string $billingStatus = '';

    public float $amount = 0.0;

    public string $currency = 'EUR';

    public \DateTimeInterface $createdAt;

    /**
     * The complete purchase payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        // Real getPurchase keys: the purchase id is `id` (not `purchase_id`), the
        // buyer is a nested object, and product info lives on the first `items` entry.
        $buyer = is_array($data['buyer'] ?? null) ? $data['buyer'] : [];
        $items = is_array($data['items'] ?? null) ? $data['items'] : [];
        $firstItem = is_array($items[0] ?? null) ? $items[0] : [];

        $purchaseId = $data['id'] ?? $data['purchase_id'] ?? '';
        $productId = $firstItem['product_id'] ?? $data['product_id'] ?? '';
        $productName = $firstItem['product_name'] ?? $data['product_name'] ?? '';
        $buyerEmail = $buyer['email'] ?? $data['buyer_email'] ?? '';
        $paymentStatus = $data['pay_status'] ?? $data['payment_status'] ?? '';
        $billingStatus = $data['billing_status'] ?? '';
        $amount = $data['amount'] ?? 0;
        $currency = $data['currency'] ?? 'EUR';
        $createdAt = $data['created_at'] ?? 'now';

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->purchaseId = TypeConverter::toString($purchaseId) ?? '';
        $response->productId = TypeConverter::toString($productId) ?? '';
        $response->productName = TypeConverter::toString($productName) ?? '';
        $response->buyerEmail = TypeConverter::toString($buyerEmail) ?? '';
        $response->paymentStatus = TypeConverter::toString($paymentStatus) ?? '';
        $response->billingStatus = TypeConverter::toString($billingStatus) ?? '';
        $response->amount = TypeConverter::toFloat($amount) ?? 0.0;
        $response->currency = TypeConverter::toString($currency) ?? 'EUR';
        $response->createdAt = TypeConverter::toDateTime($createdAt) ?? new \DateTimeImmutable();
        $response->data = $data;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
