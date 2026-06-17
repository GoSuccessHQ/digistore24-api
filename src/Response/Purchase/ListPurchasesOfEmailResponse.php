<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\PurchaseOfEmailData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Purchases Of Email Response
 *
 * Response containing the purchases belonging to a buyer's email address. The
 * API returns a plain array of purchase objects.
 *
 * @link https://digistore24.com/api/docs/paths/listPurchasesOfEmail.yaml
 */
final class ListPurchasesOfEmailResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Purchases belonging to the email address
     *
     * @var array<int, PurchaseOfEmailData>
     */
    public array $purchases = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $rawPurchases = self::extractInnerData($data);

        $purchases = [];
        foreach ($rawPurchases as $purchase) {
            if (! is_array($purchase)) {
                continue;
            }
            /** @var array<string, mixed> $validatedPurchase */
            $validatedPurchase = $purchase;
            $purchases[] = PurchaseOfEmailData::fromArray($validatedPurchase);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->purchases = $purchases;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
