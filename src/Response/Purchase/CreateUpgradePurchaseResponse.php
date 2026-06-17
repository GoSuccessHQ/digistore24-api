<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\UpgradeInfoData;
use GoSuccess\Digistore24\Api\DTO\UpgradeNewPurchaseData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create Upgrade Purchase Response
 *
 * Response after performing an upgrade. Exposes the typed `new_purchase` and
 * `upgrade_info` objects from the spec, plus the full payload via {@see self::$data}.
 *
 * @link https://digistore24.com/api/docs/paths/createUpgradePurchase.yaml
 */
final class CreateUpgradePurchaseResponse extends AbstractResponse
{
    public string $result = '';

    /** Details of the created purchase */
    public ?UpgradeNewPurchaseData $newPurchase = null;

    /** Upgrade transaction details */
    public ?UpgradeInfoData $upgradeInfo = null;

    /** @var array<string, mixed> */
    public array $data = [];

    /**
     * @return array<string, mixed>|null
     */
    public function getNewPurchase(): ?array
    {
        $newPurchase = $this->data['new_purchase'] ?? null;
        if (! is_array($newPurchase)) {
            return null;
        }
        /** @var array<string, mixed> $validated */
        $validated = $newPurchase;

        return $validated;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getUpgradeInfo(): ?array
    {
        $upgradeInfo = $this->data['upgrade_info'] ?? null;
        if (! is_array($upgradeInfo)) {
            return null;
        }
        /** @var array<string, mixed> $validated */
        $validated = $upgradeInfo;

        return $validated;
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $responseData = self::extractInnerData($data);
        /** @var array<string, mixed> $validatedData */
        $validatedData = $responseData;

        $newPurchaseRaw = $validatedData['new_purchase'] ?? null;
        $upgradeInfoRaw = $validatedData['upgrade_info'] ?? null;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->newPurchase = is_array($newPurchaseRaw)
            ? UpgradeNewPurchaseData::fromArray(self::toStringKeyedArray($newPurchaseRaw))
            : null;
        $response->upgradeInfo = is_array($upgradeInfoRaw)
            ? UpgradeInfoData::fromArray(self::toStringKeyedArray($upgradeInfoRaw))
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
