<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\BuyUrl;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Buy URL Response
 *
 * Response object for createBuyUrl endpoint.
 * Returns the created BuyUrl ID, URL, expiration, and upgrade status.
 *
 * @link https://digistore24.com/api/docs/paths/createBuyUrl.yaml
 */
final class CreateBuyUrlResponse extends AbstractResponse
{
    /**
     * ID of the BuyUrl object
     */
    public ?string $id = null;

    /**
     * Order URL for purchase
     */
    public ?string $url = null;

    /**
     * Expiration date of the URL
     */
    public ?DateTimeImmutable $validUntil = null;

    /**
     * Status of upgrade possibility (none, ok, error)
     */
    public ?string $upgradeStatus = null;

    /**
     * Create response from array data
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $instance = new self();

        if ($rawResponse !== null) {
            $instance->rawResponse = $rawResponse;
        }

        $innerData = self::extractInnerData(data: $data);

        $instance->id = isset($innerData['id']) && is_string($innerData['id']) ? $innerData['id'] : null;
        $instance->url = isset($innerData['url']) && is_string($innerData['url']) ? $innerData['url'] : null;
        $instance->validUntil = TypeConverter::toDateTime(value: $innerData['valid_until'] ?? null);
        $instance->upgradeStatus = isset($innerData['upgrade_status']) && is_string($innerData['upgrade_status']) ? $innerData['upgrade_status'] : null;

        return $instance;
    }
}
