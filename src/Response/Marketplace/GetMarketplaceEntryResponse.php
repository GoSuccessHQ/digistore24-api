<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Marketplace;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\MarketplaceEntryData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Marketplace Entry Response
 *
 * Response object for the getMarketplaceEntry endpoint, including marketplace
 * statistics.
 *
 * @link https://digistore24.com/api/docs/paths/getMarketplaceEntry.yaml
 */
final class GetMarketplaceEntryResponse extends AbstractResponse
{
    public string $result = '';

    public ?int $id = null;

    public ?int $mainProductId = null;

    /** @var list<int> */
    public array $allProductIds = [];

    public ?string $approvalStatus = null;

    public ?string $approvalStatusMsg = null;

    public ?float $price = null;

    public ?string $currency = null;

    public ?string $priceMsg = null;

    public ?string $language = null;

    public ?bool $isPriceMsgOverriden = null;

    public ?int $productCategoryId = null;

    public ?string $productCategory = null;

    public ?string $headline = null;

    public ?string $description = null;

    public ?float $affiliateShare = null;

    public ?DateTimeImmutable $productCreatedAt = null;

    public ?bool $statsIsValid = null;

    public ?DateTimeImmutable $statsUpdatedAt = null;

    public ?int $statsSellerRank = null;

    public ?int $statsSellerRankCategory = null;

    public ?float $statsStars = null;

    public ?float $statsAffiliateProfitVisitor = null;

    public ?float $statsAffiliateProfitSale = null;

    public ?int $statsCountOrdersWAff = null;

    public ?float $statsCancelRate = null;

    public ?float $statsRevenue = null;

    public ?int $statsCountAffiliatesWithSales = null;

    public ?float $statsConversionRate = null;

    public ?int $statsCountOrders = null;

    /** The marketplace entry as a typed DTO */
    public ?MarketplaceEntryData $entry = null;

    /**
     * The complete data payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $d = self::extractInnerData(data: $data);

        $allProductIds = [];
        $rawIds = $d['all_product_ids'] ?? [];
        if (is_array($rawIds)) {
            foreach ($rawIds as $rawId) {
                $id = TypeConverter::toInt($rawId);
                if ($id !== null) {
                    $allProductIds[] = $id;
                }
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->id = TypeConverter::toInt($d['id'] ?? null);
        $response->mainProductId = TypeConverter::toInt($d['main_product_id'] ?? null);
        $response->allProductIds = $allProductIds;
        $response->approvalStatus = TypeConverter::toString($d['approval_status'] ?? null);
        $response->approvalStatusMsg = TypeConverter::toString($d['approval_status_msg'] ?? null);
        $response->price = TypeConverter::toFloat($d['price'] ?? null);
        $response->currency = TypeConverter::toString($d['currency'] ?? null);
        $response->priceMsg = TypeConverter::toString($d['price_msg'] ?? null);
        $response->language = TypeConverter::toString($d['language'] ?? null);
        $response->isPriceMsgOverriden = TypeConverter::toBool($d['is_price_msg_overriden'] ?? null);
        $response->productCategoryId = TypeConverter::toInt($d['product_category_id'] ?? null);
        $response->productCategory = TypeConverter::toString($d['product_category'] ?? null);
        $response->headline = TypeConverter::toString($d['headline'] ?? null);
        $response->description = TypeConverter::toString($d['description'] ?? null);
        $response->affiliateShare = TypeConverter::toFloat($d['affiliate_share'] ?? null);
        $response->productCreatedAt = TypeConverter::toDateTime($d['product_created_at'] ?? null);
        $response->statsIsValid = TypeConverter::toBool($d['stats_is_valid'] ?? null);
        $response->statsUpdatedAt = TypeConverter::toDateTime($d['stats_updated_at'] ?? null);
        $response->statsSellerRank = TypeConverter::toInt($d['stats_seller_rank'] ?? null);
        $response->statsSellerRankCategory = TypeConverter::toInt($d['stats_seller_rank_category'] ?? null);
        $response->statsStars = TypeConverter::toFloat($d['stats_stars'] ?? null);
        $response->statsAffiliateProfitVisitor = TypeConverter::toFloat($d['stats_affiliate_profit_visitor'] ?? null);
        $response->statsAffiliateProfitSale = TypeConverter::toFloat($d['stats_affiliate_profit_sale'] ?? null);
        $response->statsCountOrdersWAff = TypeConverter::toInt($d['stats_count_orders_w_aff'] ?? null);
        $response->statsCancelRate = TypeConverter::toFloat($d['stats_cancel_rate'] ?? null);
        $response->statsRevenue = TypeConverter::toFloat($d['stats_revenue'] ?? null);
        $response->statsCountAffiliatesWithSales = TypeConverter::toInt($d['stats_count_affiliates_with_sales'] ?? null);
        $response->statsConversionRate = TypeConverter::toFloat($d['stats_conversion_rate'] ?? null);
        $response->statsCountOrders = TypeConverter::toInt($d['stats_count_orders'] ?? null);
        $response->entry = $d === [] ? null : MarketplaceEntryData::fromArray($d);
        $response->data = $d;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
