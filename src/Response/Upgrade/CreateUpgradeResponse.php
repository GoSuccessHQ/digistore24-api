<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Upgrade;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Upgrade Response
 *
 * Response for the createUpgrade endpoint.
 *
 * @link https://digistore24.com/api/docs/paths/createUpgrade.yaml
 */
final class CreateUpgradeResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The ID of the newly created upgrade.
     */
    public ?int $upgradeId = null;

    /**
     * The complete response payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public function getUpgradeId(): ?int
    {
        return $this->upgradeId;
    }

    public function wasSuccessful(): bool
    {
        return $this->result === 'success';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->upgradeId = TypeConverter::toInt($validatedData['upgrade_id'] ?? null);
        $response->data = $validatedData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
