<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\SmartUpgrade;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Smartupgrade Response
 *
 * Response object for the getSmartupgrade API endpoint. The inner `data` object
 * is a single smart-upgrade detail record. It exposes the same fields as a
 * listSmartUpgrades entry plus the rendered `widget_html` (only present when a
 * `purchase_id` is supplied in the request).
 *
 * Because the exact field set of the detail record is not fully specified, the
 * complete inner payload is also kept available via {@see self::$data}.
 *
 * @link https://digistore24.com/api/docs/paths/getSmartupgrade.yaml
 */
final class GetSmartupgradeResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Smart upgrade ID
     */
    public ?int $id = null;

    /**
     * Smart upgrade name
     */
    public ?string $name = null;

    /**
     * Authentication key used to embed the smart-upgrade widget
     */
    public ?string $authkey = null;

    /**
     * Creation timestamp
     */
    public ?DateTimeImmutable $createdAt = null;

    /**
     * Whether a custom CSS is used for the widget
     *
     * Delivered by the API as "Y"/"N" and exposed as a bool.
     */
    public ?bool $isCustomCssUsed = null;

    /**
     * Custom CSS applied to the widget (nullable)
     */
    public ?string $customCss = null;

    /**
     * Target product ID the buyer is upgraded to
     */
    public ?int $upgradeToProductId = null;

    /**
     * Comma-separated list of source product IDs the smart upgrade applies to
     */
    public ?string $productIds = null;

    /**
     * Rendered widget HTML (only returned when a `purchase_id` is provided)
     */
    public ?string $widgetHtml = null;

    /**
     * The complete inner payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->id = TypeConverter::toInt($innerData['id'] ?? null);
        $response->name = TypeConverter::toString($innerData['name'] ?? null);
        $response->authkey = TypeConverter::toString($innerData['authkey'] ?? null);
        $response->createdAt = TypeConverter::toDateTime($innerData['created_at'] ?? null);
        $response->isCustomCssUsed = TypeConverter::toBool($innerData['is_custom_css_used'] ?? null);
        $response->customCss = TypeConverter::toString($innerData['custom_css'] ?? null);
        $response->upgradeToProductId = TypeConverter::toInt($innerData['upgrade_to_product_id'] ?? null);
        $response->productIds = TypeConverter::toString($innerData['product_ids'] ?? null);
        $response->widgetHtml = TypeConverter::toString($innerData['widget_html'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
