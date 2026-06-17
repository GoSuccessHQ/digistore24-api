<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Product;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Product Response
 *
 * Response containing a single product data record. The API wraps the record in
 * a `product` key. Every field is available through the full {@see self::$data}
 * payload, and the most commonly used fields are also exposed as typed
 * properties. {@see self::$product} provides a structured accessor over the same
 * record.
 *
 * @link https://digistore24.com/api/docs/paths/getProduct.yaml
 */
final class GetProductResponse extends AbstractResponse
{
    public string $result = '';

    /** Product ID (spec key: `id`) */
    public string $id = '';

    /** Localized product name resolved for the current language */
    public string $name = '';

    /** Internal product name */
    public string $nameIntern = '';

    /** Currency code(s), e.g. "EUR" or "USD,EUR" */
    public string $currency = 'EUR';

    /** Language code(s) the product is offered in */
    public string $language = '';

    /** Product type ID */
    public int $productTypeId = 0;

    /** Product group/folder ID */
    public int $productGroupId = 0;

    /** Whether the product is active */
    public bool $isActive = false;

    /** Whether the product is deleted */
    public bool $isDeleted = false;

    /** Affiliate commission percentage as returned by the API */
    public string $affiliateCommission = '0.00';

    /** Sales page URL */
    public string $salespageUrl = '';

    /** Thank you page URL */
    public string $thankyouUrl = '';

    /** Approval status (e.g. new, pending, approved) */
    public string $approvalStatus = '';

    /** Internal note */
    public string $note = '';

    /** Buyer type (consumer or business) */
    public string $buyerType = '';

    /** Structured accessor over the full product record */
    public ProductListItem $product;

    /**
     * The complete product payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        // The API wraps the record under a `product` key. Support a flat payload
        // too (e.g. when fromArray() is called directly with the record itself).
        $product = $data['product'] ?? $data;
        if (! is_array($product)) {
            $product = [];
        }
        /** @var array<string, mixed> $productData */
        $productData = $product;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->id = TypeConverter::toString($productData['id'] ?? '') ?? '';
        $response->name = TypeConverter::toString($productData['name'] ?? '') ?? '';
        $response->nameIntern = TypeConverter::toString($productData['name_intern'] ?? '') ?? '';
        $response->currency = TypeConverter::toString($productData['currency'] ?? 'EUR') ?? 'EUR';
        $response->language = TypeConverter::toString($productData['language'] ?? '') ?? '';
        $response->productTypeId = TypeConverter::toInt($productData['product_type_id'] ?? 0) ?? 0;
        $response->productGroupId = TypeConverter::toInt($productData['product_group_id'] ?? 0) ?? 0;
        $response->isActive = TypeConverter::toBool($productData['is_active'] ?? false) ?? false;
        $response->isDeleted = TypeConverter::toBool($productData['is_deleted'] ?? false) ?? false;
        $response->affiliateCommission = TypeConverter::toString($productData['affiliate_commission'] ?? '0.00') ?? '0.00';
        $response->salespageUrl = TypeConverter::toString($productData['salespage_url'] ?? '') ?? '';
        $response->thankyouUrl = TypeConverter::toString($productData['thankyou_url'] ?? '') ?? '';
        $response->approvalStatus = TypeConverter::toString($productData['approval_status'] ?? '') ?? '';
        $response->note = TypeConverter::toString($productData['note'] ?? '') ?? '';
        $response->buyerType = TypeConverter::toString($productData['buyer_type'] ?? '') ?? '';
        $response->product = ProductListItem::fromArray($productData);
        $response->data = $productData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
