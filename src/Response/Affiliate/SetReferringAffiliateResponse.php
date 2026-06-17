<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Enum\ReferringAffiliateAction;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Set Referring Affiliate Response
 *
 * Response object for assigning a referring partner to an affiliate. Mirrors the
 * spec's `data` object.
 *
 * @link https://digistore24.com/api/docs/paths/setReferringAffiliate.yaml
 */
final class SetReferringAffiliateResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * What the call did with the referral relationship
     */
    public ?ReferringAffiliateAction $action = null;

    /**
     * ID of the referred affiliate
     */
    public ?string $affiliateId = null;

    /**
     * Username of the referred affiliate
     */
    public ?string $affiliateName = null;

    /**
     * ID of the referring partner
     */
    public ?string $referrerId = null;

    /**
     * Username of the referring partner
     */
    public ?string $referrerName = null;

    /**
     * Commission percentage paid to the referring partner
     */
    public ?float $commission = null;

    /**
     * When the referral was created
     */
    public ?\DateTimeInterface $createdAt = null;

    /**
     * ID of the user who created the referral
     */
    public ?string $createdBy = null;

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

        $action = null;
        if (isset($innerData['action']) && is_string($innerData['action'])) {
            $action = ReferringAffiliateAction::fromString($innerData['action']);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->action = $action;
        $response->affiliateId = TypeConverter::toString($innerData['affiliate_id'] ?? null);
        $response->affiliateName = TypeConverter::toString($innerData['affiliate_name'] ?? null);
        $response->referrerId = TypeConverter::toString($innerData['referrer_id'] ?? null);
        $response->referrerName = TypeConverter::toString($innerData['referrer_name'] ?? null);
        $response->commission = TypeConverter::toFloat($innerData['commission'] ?? null);
        $response->createdAt = TypeConverter::toDateTime($innerData['created_at'] ?? null);
        $response->createdBy = TypeConverter::toString($innerData['created_by'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
