<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Marketplace Entry Data Transfer Object
 *
 * One marketplace entry as returned by getMarketplaceEntry and as an item of the
 * listMarketplaceEntries array, including the marketplace statistics. Read-only
 * response fields.
 *
 * @link https://digistore24.com/api/docs/paths/getMarketplaceEntry.yaml
 * @link https://digistore24.com/api/docs/paths/listMarketplaceEntries.yaml
 */
final class MarketplaceEntryData extends AbstractDataTransferObject
{
    /** ID of the marketplace entry */
    public ?int $id {
        get => $this->id;
    }

    /** ID of the main product */
    public ?int $mainProductId {
        get => $this->mainProductId;
    }

    /**
     * All product IDs including main product and related products
     *
     * @var list<int>
     */
    public array $allProductIds {
        get => $this->allProductIds;
    }

    /** Approval status (new, pending, approved, rejected) */
    public ?string $approvalStatus {
        get => $this->approvalStatus;
    }

    /** Approval status in plain text */
    public ?string $approvalStatusMsg {
        get => $this->approvalStatusMsg;
    }

    /** Estimated or statistical average product price */
    public ?float $price {
        get => $this->price;
    }

    /** Currency code for all prices */
    public ?string $currency {
        get => $this->currency;
    }

    /** Product price as HTML text */
    public ?string $priceMsg {
        get => $this->priceMsg;
    }

    /** Two-letter language code (e.g. de or en) */
    public ?string $language {
        get => $this->language;
    }

    /** Whether price_msg was manually entered */
    public ?bool $isPriceMsgOverriden {
        get => $this->isPriceMsgOverriden;
    }

    /** Category ID of the marketplace entry */
    public ?int $productCategoryId {
        get => $this->productCategoryId;
    }

    /** Category name */
    public ?string $productCategory {
        get => $this->productCategory;
    }

    /** Headline of the marketplace entry */
    public ?string $headline {
        get => $this->headline;
    }

    /** Description text in HTML format */
    public ?string $description {
        get => $this->description;
    }

    /** Expected affiliate share percentage for a sale */
    public ?float $affiliateShare {
        get => $this->affiliateShare;
    }

    /** Product creation timestamp */
    public ?DateTimeImmutable $productCreatedAt {
        get => $this->productCreatedAt;
    }

    /** Whether there are enough sales for valid statistics */
    public ?bool $statsIsValid {
        get => $this->statsIsValid;
    }

    /** When statistics were last updated */
    public ?DateTimeImmutable $statsUpdatedAt {
        get => $this->statsUpdatedAt;
    }

    /** Overall Digistore24 seller rank */
    public ?int $statsSellerRank {
        get => $this->statsSellerRank;
    }

    /** Seller rank within product category */
    public ?int $statsSellerRankCategory {
        get => $this->statsSellerRankCategory;
    }

    /** Popularity rating from 0 to 5 stars */
    public ?float $statsStars {
        get => $this->statsStars;
    }

    /** Average affiliate profit per order form visitor */
    public ?float $statsAffiliateProfitVisitor {
        get => $this->statsAffiliateProfitVisitor;
    }

    /** Average affiliate profit per initial sale */
    public ?float $statsAffiliateProfitSale {
        get => $this->statsAffiliateProfitSale;
    }

    /** Number of orders with affiliates */
    public ?int $statsCountOrdersWAff {
        get => $this->statsCountOrdersWAff;
    }

    /** Cancellation rate percentage */
    public ?float $statsCancelRate {
        get => $this->statsCancelRate;
    }

    /** Total net revenue including subscriptions and upsells */
    public ?float $statsRevenue {
        get => $this->statsRevenue;
    }

    /** Number of affiliates that generated sales */
    public ?int $statsCountAffiliatesWithSales {
        get => $this->statsCountAffiliatesWithSales;
    }

    /** Cart conversion rate percentage */
    public ?float $statsConversionRate {
        get => $this->statsConversionRate;
    }

    /** Total number of orders */
    public ?int $statsCountOrders {
        get => $this->statsCountOrders;
    }

    /**
     * @param list<int> $allProductIds
     */
    public function __construct(
        ?int $id = null,
        ?int $mainProductId = null,
        array $allProductIds = [],
        ?string $approvalStatus = null,
        ?string $approvalStatusMsg = null,
        ?float $price = null,
        ?string $currency = null,
        ?string $priceMsg = null,
        ?string $language = null,
        ?bool $isPriceMsgOverriden = null,
        ?int $productCategoryId = null,
        ?string $productCategory = null,
        ?string $headline = null,
        ?string $description = null,
        ?float $affiliateShare = null,
        ?DateTimeImmutable $productCreatedAt = null,
        ?bool $statsIsValid = null,
        ?DateTimeImmutable $statsUpdatedAt = null,
        ?int $statsSellerRank = null,
        ?int $statsSellerRankCategory = null,
        ?float $statsStars = null,
        ?float $statsAffiliateProfitVisitor = null,
        ?float $statsAffiliateProfitSale = null,
        ?int $statsCountOrdersWAff = null,
        ?float $statsCancelRate = null,
        ?float $statsRevenue = null,
        ?int $statsCountAffiliatesWithSales = null,
        ?float $statsConversionRate = null,
        ?int $statsCountOrders = null,
    ) {
        $this->id = $id;
        $this->mainProductId = $mainProductId;
        $this->allProductIds = $allProductIds;
        $this->approvalStatus = $approvalStatus;
        $this->approvalStatusMsg = $approvalStatusMsg;
        $this->price = $price;
        $this->currency = $currency;
        $this->priceMsg = $priceMsg;
        $this->language = $language;
        $this->isPriceMsgOverriden = $isPriceMsgOverriden;
        $this->productCategoryId = $productCategoryId;
        $this->productCategory = $productCategory;
        $this->headline = $headline;
        $this->description = $description;
        $this->affiliateShare = $affiliateShare;
        $this->productCreatedAt = $productCreatedAt;
        $this->statsIsValid = $statsIsValid;
        $this->statsUpdatedAt = $statsUpdatedAt;
        $this->statsSellerRank = $statsSellerRank;
        $this->statsSellerRankCategory = $statsSellerRankCategory;
        $this->statsStars = $statsStars;
        $this->statsAffiliateProfitVisitor = $statsAffiliateProfitVisitor;
        $this->statsAffiliateProfitSale = $statsAffiliateProfitSale;
        $this->statsCountOrdersWAff = $statsCountOrdersWAff;
        $this->statsCancelRate = $statsCancelRate;
        $this->statsRevenue = $statsRevenue;
        $this->statsCountAffiliatesWithSales = $statsCountAffiliatesWithSales;
        $this->statsConversionRate = $statsConversionRate;
        $this->statsCountOrders = $statsCountOrders;
    }

    public static function fromArray(array $data): static
    {
        $allProductIds = [];
        $rawIds = $data['all_product_ids'] ?? [];
        if (is_array($rawIds)) {
            foreach ($rawIds as $rawId) {
                $productId = TypeConverter::toInt($rawId);
                if ($productId !== null) {
                    $allProductIds[] = $productId;
                }
            }
        }

        return new self(
            id: TypeConverter::toInt($data['id'] ?? null),
            mainProductId: TypeConverter::toInt($data['main_product_id'] ?? null),
            allProductIds: $allProductIds,
            approvalStatus: TypeConverter::toString($data['approval_status'] ?? null),
            approvalStatusMsg: TypeConverter::toString($data['approval_status_msg'] ?? null),
            price: TypeConverter::toFloat($data['price'] ?? null),
            currency: TypeConverter::toString($data['currency'] ?? null),
            priceMsg: TypeConverter::toString($data['price_msg'] ?? null),
            language: TypeConverter::toString($data['language'] ?? null),
            isPriceMsgOverriden: TypeConverter::toBool($data['is_price_msg_overriden'] ?? null),
            productCategoryId: TypeConverter::toInt($data['product_category_id'] ?? null),
            productCategory: TypeConverter::toString($data['product_category'] ?? null),
            headline: TypeConverter::toString($data['headline'] ?? null),
            description: TypeConverter::toString($data['description'] ?? null),
            affiliateShare: TypeConverter::toFloat($data['affiliate_share'] ?? null),
            productCreatedAt: TypeConverter::toDateTime($data['product_created_at'] ?? null),
            statsIsValid: TypeConverter::toBool($data['stats_is_valid'] ?? null),
            statsUpdatedAt: TypeConverter::toDateTime($data['stats_updated_at'] ?? null),
            statsSellerRank: TypeConverter::toInt($data['stats_seller_rank'] ?? null),
            statsSellerRankCategory: TypeConverter::toInt($data['stats_seller_rank_category'] ?? null),
            statsStars: TypeConverter::toFloat($data['stats_stars'] ?? null),
            statsAffiliateProfitVisitor: TypeConverter::toFloat($data['stats_affiliate_profit_visitor'] ?? null),
            statsAffiliateProfitSale: TypeConverter::toFloat($data['stats_affiliate_profit_sale'] ?? null),
            statsCountOrdersWAff: TypeConverter::toInt($data['stats_count_orders_w_aff'] ?? null),
            statsCancelRate: TypeConverter::toFloat($data['stats_cancel_rate'] ?? null),
            statsRevenue: TypeConverter::toFloat($data['stats_revenue'] ?? null),
            statsCountAffiliatesWithSales: TypeConverter::toInt($data['stats_count_affiliates_with_sales'] ?? null),
            statsConversionRate: TypeConverter::toFloat($data['stats_conversion_rate'] ?? null),
            statsCountOrders: TypeConverter::toInt($data['stats_count_orders'] ?? null),
        );
    }
}
