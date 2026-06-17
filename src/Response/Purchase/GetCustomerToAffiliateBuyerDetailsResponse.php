<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\CustomerToAffiliateDetailsData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Customer To Affiliate Buyer Details Response
 *
 * Response containing customer-to-affiliate program details for the queried
 * buyer(s). For a single order the API returns one `data` object; for multiple
 * comma-separated order IDs it returns a map of purchase ID => details.
 *
 * @link https://digistore24.com/api/docs/paths/getCustomerToAffiliateBuyerDetails.yaml
 */
final class GetCustomerToAffiliateBuyerDetailsResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Typed details for the (first/only) buyer.
     */
    public ?CustomerToAffiliateDetailsData $details = null;

    /**
     * Typed details keyed by purchase ID when multiple order IDs are queried.
     *
     * @var array<string, CustomerToAffiliateDetailsData>
     */
    public array $detailsByPurchase = [];

    /**
     * The complete payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData($data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $innerData;

        // Single-buyer shape: the details fields live directly in this object.
        if (self::looksLikeDetails($innerData)) {
            $response->details = CustomerToAffiliateDetailsData::fromArray($innerData);
        } else {
            // Multi-buyer shape: map of purchase_id => { ...details }.
            foreach ($innerData as $key => $value) {
                if (! is_array($value)) {
                    continue;
                }
                /** @var array<string, mixed> $entry */
                $entry = self::toStringKeyedArray($value);
                $details = CustomerToAffiliateDetailsData::fromArray($entry);
                $response->detailsByPurchase[(string)$key] = $details;
            }

            // Expose the first entry as the convenience `details` accessor.
            $first = $response->detailsByPurchase[array_key_first($response->detailsByPurchase) ?? ''] ?? null;
            $response->details = $first;
        }

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @param array<string, mixed> $data
     */
    private static function looksLikeDetails(array $data): bool
    {
        return array_key_exists('customer_affiliate_name', $data)
            || array_key_exists('customer_to_affiliate_url', $data)
            || array_key_exists('customer_affiliate_promo_url', $data);
    }

    /**
     * @param array<mixed, mixed> $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(array $value): array
    {
        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
