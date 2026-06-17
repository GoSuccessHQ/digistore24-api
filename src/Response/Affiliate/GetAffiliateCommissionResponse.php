<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\AffiliationData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Affiliate Commission Response
 *
 * Response object for retrieving affiliate commission settings. Mirrors the
 * spec's `commissions` array; every commission entry exposes at least the
 * spec fields (commission_rate, commission_fix, commission_currency,
 * approval_status) and the additional fields the live API returns.
 *
 * @link https://digistore24.com/api/docs/paths/getAffiliateCommission.yaml
 */
final class GetAffiliateCommissionResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Commission entries, one per product (spec key: `commissions`)
     *
     * @var array<int, AffiliationData>
     */
    public array $commissions = [];

    /**
     * Affiliate ID (returned by the live API alongside the commissions)
     */
    public string $affiliateId = '';

    /**
     * Affiliate name (returned by the live API alongside the commissions)
     */
    public string $affiliateName = '';

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

        $commissionsData = $innerData['commissions'] ?? [];
        $commissions = [];

        if (is_array($commissionsData)) {
            foreach ($commissionsData as $commissionItem) {
                if (! is_array($commissionItem)) {
                    continue;
                }
                /** @var array<string, mixed> $validCommissionItem */
                $validCommissionItem = $commissionItem;
                $commissions[] = AffiliationData::fromArray(data: $validCommissionItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->commissions = $commissions;
        $response->affiliateId = TypeConverter::toString($innerData['affiliate_id'] ?? null) ?? '';
        $response->affiliateName = TypeConverter::toString($innerData['affiliate_name'] ?? null) ?? '';
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
