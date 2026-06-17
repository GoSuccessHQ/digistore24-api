<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\CustomForm;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\CustomFormRecordData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Response containing custom form records.
 *
 * Each entry exposes the full spec field set via {@see CustomFormRecordData}.
 *
 * @link https://digistore24.com/api/docs/paths/listCustomFormRecords.yaml
 */
final class ListCustomFormRecordsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Custom form records (spec key: `records`)
     *
     * @var array<int, CustomFormRecordData>
     */
    public array $records = [];

    /**
     * Get records for a specific purchase.
     *
     * @return array<int, CustomFormRecordData>
     */
    public function getRecordsByPurchaseId(string $purchaseId): array
    {
        return array_values(array_filter(
            $this->records,
            static fn (CustomFormRecordData $record): bool => $record->purchaseId === $purchaseId,
        ));
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $records = [];
        $recordsData = $innerData['records'] ?? [];
        if (is_array($recordsData)) {
            foreach ($recordsData as $item) {
                if (! is_array($item)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedItem */
                $validatedItem = $item;
                $records[] = CustomFormRecordData::fromArray($validatedItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->records = $records;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
