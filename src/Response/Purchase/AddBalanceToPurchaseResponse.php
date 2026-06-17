<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Add Balance To Purchase Response
 *
 * Response object for the Purchase API endpoint.
 */
final class AddBalanceToPurchaseResponse extends AbstractResponse
{
    public string $result = '';

    public float $oldBalance = 0.0;

    public float $newBalance = 0.0;

    public function getBalanceChange(): float
    {
        return $this->newBalance - $this->oldBalance;
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $oldBalance = $innerData['old_balance'] ?? 0.0;
        $newBalance = $innerData['new_balance'] ?? 0.0;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->oldBalance = TypeConverter::toFloat($oldBalance) ?? 0.0;
        $response->newBalance = TypeConverter::toFloat($newBalance) ?? 0.0;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
