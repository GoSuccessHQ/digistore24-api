<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * List Purchases Response
 *
 * Response containing a list of purchases. The real API returns the list under
 * the `purchase_list` key; the legacy `purchases` key is also accepted.
 *
 * @link https://digistore24.com/api/docs/paths/listPurchases.yaml
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

        $rawList = $data['purchase_list'] ?? $data['purchases'] ?? null;
        if (is_array($rawList)) {
            foreach ($rawList as $purchase) {
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
