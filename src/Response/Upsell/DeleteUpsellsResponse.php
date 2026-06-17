<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Upsell;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Delete Upsells Response
 *
 * Response confirming the deletion of a product's upsell tree.
 *
 * @link https://digistore24.com/api/docs/paths/deleteUpsells.yaml
 */
final class DeleteUpsellsResponse extends AbstractResponse
{
    public string $result = '';

    /** Whether the upsell tree was deleted (Y), or was already deleted (N) */
    public ?bool $isModified = null;

    public function wasSuccessful(): bool
    {
        return $this->result === 'success';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->isModified = TypeConverter::toBool($innerData['is_modified'] ?? null);
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
