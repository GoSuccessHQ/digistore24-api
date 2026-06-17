<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\BuyUrl;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Enum\UpgradeStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Buy URL Response
 *
 * Response object for the createBuyUrl endpoint. Mirrors the spec's `data`
 * object: the created BuyUrl ID, the order URL, its expiration, and the
 * upgrade status.
 *
 * @link https://digistore24.com/api/docs/paths/createBuyUrl.yaml
 */
final class CreateBuyUrlResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

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
    public ?UpgradeStatus $upgradeStatus = null;

    /**
     * The complete inner payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * Create response from array data
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $instance = new self();
        $instance->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $instance->id = TypeConverter::toString($innerData['id'] ?? null);
        $instance->url = TypeConverter::toString($innerData['url'] ?? null);
        $instance->validUntil = TypeConverter::toDateTime(value: $innerData['valid_until'] ?? null);
        $instance->upgradeStatus = isset($innerData['upgrade_status']) && is_string($innerData['upgrade_status'])
            ? UpgradeStatus::fromString($innerData['upgrade_status'])
            : null;
        $instance->data = $innerData;

        if ($rawResponse !== null) {
            $instance->rawResponse = $rawResponse;
        }

        return $instance;
    }
}
