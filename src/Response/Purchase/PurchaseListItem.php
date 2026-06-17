<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use DateTimeImmutable;
use DateTimeInterface;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Purchase List Item
 *
 * Represents a single purchase entry returned by listPurchases. The spec
 * formally documents the affiliate fields `click_id` and `sub_ids` (sid1..sid5)
 * for each entry; the remaining commonly returned fields (purchase_id,
 * product_id, buyer_email, etc.) are also exposed. The complete entry payload is
 * available via {@see self::$data}.
 *
 * @link https://digistore24.com/api/docs/paths/listPurchases.yaml
 */
final class PurchaseListItem
{
    /**
     * Affiliate click ID (only for affiliate purchases)
     */
    public ?string $clickId = null;

    /**
     * Affiliate sub IDs (only for affiliate purchases): keys sid1..sid5
     *
     * @var array<string, string>
     */
    public array $subIds = [];

    /**
     * The complete purchase entry payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * @param array<string, string> $subIds
     * @param array<string, mixed> $data
     */
    public function __construct(
        public readonly string $purchaseId,
        public readonly string $productId,
        public readonly string $productName,
        public readonly string $buyerEmail,
        public readonly string $paymentStatus,
        public readonly float $amount,
        public readonly string $currency,
        public readonly DateTimeInterface $createdAt,
        ?string $clickId = null,
        array $subIds = [],
        array $data = [],
    ) {
        $this->clickId = $clickId;
        $this->subIds = $subIds;
        $this->data = $data;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $purchaseId = $data['purchase_id'] ?? '';
        $productId = $data['product_id'] ?? '';
        $productName = $data['product_name'] ?? '';
        $buyerEmail = $data['buyer_email'] ?? '';
        $paymentStatus = $data['payment_status'] ?? '';
        $amount = $data['amount'] ?? 0;
        $currency = $data['currency'] ?? 'EUR';
        $createdAt = $data['created_at'] ?? 'now';

        $subIds = [];
        if (isset($data['sub_ids']) && is_array($data['sub_ids'])) {
            foreach ($data['sub_ids'] as $key => $value) {
                if (is_scalar($value)) {
                    $subIds[(string)$key] = (string)$value;
                }
            }
        }

        return new self(
            purchaseId: TypeConverter::toString($purchaseId) ?? '',
            productId: TypeConverter::toString($productId) ?? '',
            productName: TypeConverter::toString($productName) ?? '',
            buyerEmail: TypeConverter::toString($buyerEmail) ?? '',
            paymentStatus: TypeConverter::toString($paymentStatus) ?? '',
            amount: TypeConverter::toFloat($amount) ?? 0.0,
            currency: TypeConverter::toString($currency) ?? 'EUR',
            createdAt: TypeConverter::toDateTime($createdAt) ?? new DateTimeImmutable(),
            clickId: TypeConverter::toString($data['click_id'] ?? null),
            subIds: $subIds,
            data: $data,
        );
    }
}
