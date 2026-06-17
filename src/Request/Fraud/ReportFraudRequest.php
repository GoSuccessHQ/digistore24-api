<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Fraud;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Request to report fraud.
 *
 * Reports the customer and/or the affiliate as fraud.
 *
 * @see https://digistore24.com/api/docs/paths/reportFraud.yaml
 */
final class ReportFraudRequest extends AbstractRequest
{
    /**
     * @param int $transactionId The numeric ID of the fraud transaction
     * @param string $who Who is being reported ("buyer", "affiliate", or "buyer,affiliate")
     * @param string $comment Explanation of why this is considered a fraud order
     */
    public function __construct(
        private int $transactionId,
        private string $who,
        private string $comment,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/reportFraud';
    }

    public function toArray(): array
    {
        return [
            'transaction_id' => $this->transactionId,
            'who' => $this->who,
            'comment' => $this->comment,
        ];
    }
}
