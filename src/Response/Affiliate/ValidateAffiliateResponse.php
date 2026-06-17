<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Enum\AffiliationStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Validate Affiliate Response
 *
 * Response object for checking whether an affiliation exists for an affiliate
 * and one or more products. Mirrors the spec's `data` object.
 *
 * @link https://digistore24.com/api/docs/paths/validateAffiliate.yaml
 */
final class ValidateAffiliateResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Whether the affiliation exists and has been approved for all specified
     * products (spec key: `have_affiliation`, returned as "Y"/"N").
     */
    public ?bool $haveAffiliation = null;

    /**
     * Status of the affiliation
     */
    public ?AffiliationStatus $affiliationStatus = null;

    /**
     * Whether the affiliate name is not valid
     */
    public ?bool $invalidAffiliateName = null;

    /**
     * Human-readable status message
     */
    public ?string $affiliationStatusMsg = null;

    /**
     * URL via which the affiliation can be initiated
     */
    public ?string $inviteUrl = null;

    /**
     * Comma-separated list of valid product IDs
     */
    public ?string $validProductIds = null;

    /**
     * Comma-separated list of invalid product IDs
     */
    public ?string $invalidProductIds = null;

    /**
     * The complete payload as returned by the API, so every field is accessible
     * even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $affiliationStatus = null;
        if (isset($innerData['affiliation_status']) && is_string($innerData['affiliation_status'])) {
            $affiliationStatus = AffiliationStatus::fromString($innerData['affiliation_status']);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->haveAffiliation = TypeConverter::toBool($innerData['have_affiliation'] ?? null);
        $response->affiliationStatus = $affiliationStatus;
        $response->invalidAffiliateName = TypeConverter::toBool($innerData['invalid_affiliate_name'] ?? null);
        $response->affiliationStatusMsg = TypeConverter::toString($innerData['affiliation_status_msg'] ?? null);
        $response->inviteUrl = TypeConverter::toString($innerData['invite_url'] ?? null);
        $response->validProductIds = TypeConverter::toString($innerData['valid_product_ids'] ?? null);
        $response->invalidProductIds = TypeConverter::toString($innerData['invalid_product_ids'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
