<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Transaction;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Refund Transaction Request
 *
 * Processes a full refund for a specific transaction.
 *
 * @link https://digistore24.com/api/docs/paths/refundTransaction.yaml
 */
final class RefundTransactionRequest extends AbstractRequest
{
    /**
     * @param string $transactionId The unique identifier of the transaction to refund
     * @param bool|null $force Force refund even if outside refund period
     * @param string|null $requestDate Optional custom request date (format: YYYY-MM-DD)
     */
    public function __construct(
        private string $transactionId,
        private ?bool $force = null,
        private ?string $requestDate = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/refundTransaction';
    }

    public function toArray(): array
    {
        $params = ['transaction_id' => $this->transactionId];
        if ($this->force !== null) {
            $params['force'] = TypeConverter::fromBool($this->force);
        }
        if ($this->requestDate !== null) {
            $params['request_date'] = $this->requestDate;
        }

        return $params;
    }
}
