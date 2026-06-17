<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Ipn;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * IPN Setup Response
 *
 * Response for creating an IPN connection.
 * Contains IPN configuration details including domain ID, passphrase, and IPN IDs.
 */
final class IpnSetupResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Whether the IPN was created (Y/N)
     */
    public ?bool $created = null;

    /**
     * Whether the IPN was updated (Y/N)
     */
    public ?bool $updated = null;

    /**
     * Whether the IPN was deleted (Y/N)
     */
    public ?bool $deleted = null;

    /**
     * Domain ID used to identify the IPN connection
     */
    public ?string $domainId = null;

    /**
     * SHA passphrase for signing parameters
     */
    public ?string $shaPassphrase = null;

    /**
     * IPN configuration ID
     */
    public ?int $ipnConfigId = null;

    /**
     * IPN ID
     */
    public ?int $ipnId = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);

        // Extract data from nested 'data' field
        $innerData = self::extractInnerData(data: $data);

        $response->created = TypeConverter::toBool($innerData['created'] ?? null);
        $response->updated = TypeConverter::toBool($innerData['updated'] ?? null);
        $response->deleted = TypeConverter::toBool($innerData['deleted'] ?? null);
        $response->domainId = TypeConverter::toString($innerData['domain_id'] ?? null);
        $response->shaPassphrase = TypeConverter::toString($innerData['sha_passphrase'] ?? null);
        $response->ipnConfigId = TypeConverter::toInt($innerData['ipn_config_id'] ?? null);
        $response->ipnId = TypeConverter::toInt($innerData['ipn_id'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
