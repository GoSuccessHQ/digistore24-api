<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\CustomForm;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Response containing custom form records.
 *
 * @see https://digistore24.com/api/docs/paths/listCustomFormRecords.yaml
 */
final class ListCustomFormRecordsResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Custom form records
     *
     * @var array<int, object{form_id: int, id: int, purchase_id: string, purchase_item_id: int, product_id: int, form_no: int, form_count: int, data: array<string, string>, address: array<string, string>}>
     */
    public array $records = [];

    /**
     * Get records for a specific purchase.
     *
     * @return array<int, object{form_id: int, id: int, purchase_id: string, purchase_item_id: int, product_id: int, form_no: int, form_count: int, data: array<string, string>, address: array<string, string>}>
     */
    public function getRecordsByPurchaseId(string $purchaseId): array
    {
        return array_filter(
            $this->records,
            fn ($record) => $record->purchase_id === $purchaseId,
        );
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

                $formId = $item['form_id'] ?? 0;
                $id = $item['id'] ?? 0;
                $purchaseId = $item['purchase_id'] ?? '';
                $purchaseItemId = $item['purchase_item_id'] ?? 0;
                $productId = $item['product_id'] ?? 0;
                $formNo = $item['form_no'] ?? 0;
                $formCount = $item['form_count'] ?? 0;
                $itemData = $item['data'] ?? [];
                $address = $item['address'] ?? [];

                /** @var array<string, string> $validatedData */
                $validatedData = is_array($itemData) ? $itemData : [];
                /** @var array<string, string> $validatedAddress */
                $validatedAddress = is_array($address) ? $address : [];

                $records[] = (object)[
                    'form_id' => is_int($formId) ? $formId : 0,
                    'id' => is_int($id) ? $id : 0,
                    'purchase_id' => is_string($purchaseId) ? $purchaseId : '',
                    'purchase_item_id' => is_int($purchaseItemId) ? $purchaseItemId : 0,
                    'product_id' => is_int($productId) ? $productId : 0,
                    'form_no' => is_int($formNo) ? $formNo : 0,
                    'form_count' => is_int($formCount) ? $formCount : 0,
                    'data' => $validatedData,
                    'address' => $validatedAddress,
                ];
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
