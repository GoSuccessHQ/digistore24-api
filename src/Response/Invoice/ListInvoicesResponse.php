<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Invoice;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Invoices Response
 *
 * Response object for the Invoice API endpoint.
 */
final class ListInvoicesResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Purchase ID
     */
    public string $purchaseId = '';

    /**
     * Invoice list
     *
     * @var array<string, mixed>
     */
    public array $invoiceList = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $invoiceList = $innerData['invoice_list'] ?? [];
        if (! is_array($invoiceList)) {
            $invoiceList = [];
        }
        /** @var array<string, mixed> $validatedInvoiceList */
        $validatedInvoiceList = $invoiceList;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->purchaseId = is_string($innerData['purchase_id'] ?? null) ? $innerData['purchase_id'] : '';
        $response->invoiceList = $validatedInvoiceList;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
