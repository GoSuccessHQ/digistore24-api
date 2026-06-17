<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\UpgradeCheckData;
use GoSuccess\Digistore24\Api\DTO\UpgradeItemData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Upgrade Response
 *
 * Response for the getUpgrade endpoint. The payload contains the upgrade itself
 * under `item` and, when order IDs were supplied, an `check` object reporting
 * whether the upgrade is possible for those orders.
 *
 * @link https://digistore24.com/api/docs/paths/getUpgrade.yaml
 */
final class GetUpgradeResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The upgrade details (spec key: `item`).
     */
    public ?UpgradeItemData $item = null;

    /**
     * Upgrade possibility check for the supplied order IDs (spec key: `check`),
     * present only when `order_ids` were passed to the request.
     */
    public ?UpgradeCheckData $check = null;

    /**
     * The complete inner payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData($data);
        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;

        $itemData = $validatedData['item'] ?? null;
        $checkData = $validatedData['check'] ?? null;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->item = is_array($itemData)
            ? UpgradeItemData::fromArray(self::toStringKeyedArray($itemData))
            : null;
        $response->check = is_array($checkData)
            ? UpgradeCheckData::fromArray(self::toStringKeyedArray($checkData))
            : null;
        $response->data = $validatedData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
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
