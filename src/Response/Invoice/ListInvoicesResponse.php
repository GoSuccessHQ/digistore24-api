<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Invoice;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\InvoiceData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Invoices Response
 *
 * Contains all invoices for a purchase. Each entry exposes the full spec field
 * set via {@see InvoiceData}.
 *
 * @link https://digistore24.com/api/docs/paths/listInvoices.yaml
 */
final class ListInvoicesResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Digistore24 order ID
     */
    public string $purchaseId = '';

    /**
     * Invoice records (spec key: `invoice_list`)
     *
     * @var array<int, InvoiceData>
     */
    public array $invoiceList = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $invoiceListData = $innerData['invoice_list'] ?? [];
        $invoiceList = [];

        if (is_array($invoiceListData)) {
            foreach ($invoiceListData as $item) {
                if (! is_array($item)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedItem */
                $validatedItem = $item;
                $invoiceList[] = InvoiceData::fromArray($validatedItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->purchaseId = TypeConverter::toString($innerData['purchase_id'] ?? null) ?? '';
        $response->invoiceList = $invoiceList;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
