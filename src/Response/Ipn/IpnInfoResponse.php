<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Ipn;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * IPN Info Response
 *
 * Response containing IPN connection settings, i.e. the settings that were
 * transferred when the connection was created by ipnSetup. The settings are
 * exposed both as typed properties and through the complete `data` echo.
 *
 * @link https://digistore24.com/api/docs/paths/ipnInfo.yaml
 */
final class IpnInfoResponse extends AbstractResponse
{
    public string $result = '';

    /** IPN URL where Digistore24 sends the notification */
    public ?string $url = null;

    /** The name listed on Digistore */
    public ?string $name = null;

    /** "all" or a comma-separated list of product IDs */
    public ?string $productIds = null;

    /** Domain ID identifying the IPN connection */
    public ?string $domainId = null;

    /** Comma-separated transaction categories */
    public ?string $categories = null;

    /** Comma-separated transaction types */
    public ?string $transactions = null;

    /** Notification trigger point (before_thankyou or delayed) */
    public ?string $timing = null;

    /** Newsletter send policy */
    public ?string $newsletterSendPolicy = null;

    /**
     * The complete settings echo as returned by the API, so every field is
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
        $response->url = TypeConverter::toString($innerData['url'] ?? $innerData['ipn_url'] ?? null);
        $response->name = TypeConverter::toString($innerData['name'] ?? null);
        $response->productIds = TypeConverter::toString($innerData['product_ids'] ?? null);
        $response->domainId = TypeConverter::toString($innerData['domain_id'] ?? null);
        $response->categories = TypeConverter::toString($innerData['categories'] ?? null);
        $response->transactions = TypeConverter::toString($innerData['transactions'] ?? null);
        $response->timing = TypeConverter::toString($innerData['timing'] ?? null);
        $response->newsletterSendPolicy = TypeConverter::toString($innerData['newsletter_send_policy'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
