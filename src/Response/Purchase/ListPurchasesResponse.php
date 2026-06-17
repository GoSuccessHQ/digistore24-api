<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Purchases Response
 *
 * Response containing a list of purchases.
 */
final class ListPurchasesResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<PurchaseListItem> Array of purchase list items */
    public array $purchases = [];

    /** Total number of purchases */
    public int $totalCount = 0;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $purchases = [];

        if (isset($data['purchases']) && is_array($data['purchases'])) {
            foreach ($data['purchases'] as $purchase) {
                if (! is_array($purchase)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedPurchase */
                $validatedPurchase = $purchase;
                $purchases[] = PurchaseListItem::fromArray($validatedPurchase);
            }
        }

        $totalCount = $data['total_count'] ?? count($purchases);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->purchases = $purchases;
        $response->totalCount = TypeConverter::toInt($totalCount) ?? count($purchases);
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
