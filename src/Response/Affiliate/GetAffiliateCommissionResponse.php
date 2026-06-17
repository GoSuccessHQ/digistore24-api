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
 * Response object for retrieving affiliate commission settings.
 */
final class GetAffiliateCommissionResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Array of affiliation commission data
     *
     * @var array<AffiliationData>
     */
    public array $affiliations = [];

    /**
     * Affiliate ID
     */
    public string $affiliateId = '';

    /**
     * Affiliate name
     */
    public string $affiliateName = '';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $affiliationsData = $innerData['affiliations'] ?? [];
        $affiliations = [];

        if (is_array($affiliationsData)) {
            foreach ($affiliationsData as $affiliationItem) {
                if (! is_array($affiliationItem)) {
                    continue;
                }
                /** @var array<string, mixed> $validAffiliationItem */
                $validAffiliationItem = $affiliationItem;
                $affiliations[] = AffiliationData::fromArray(data: $validAffiliationItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->affiliations = $affiliations;
        $response->affiliateId = TypeConverter::toString($innerData['affiliate_id'] ?? null) ?? '';
        $response->affiliateName = TypeConverter::toString($innerData['affiliate_name'] ?? null) ?? '';

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
