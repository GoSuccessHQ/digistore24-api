<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Transaction;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Enum\RefundErrorReason;
use GoSuccess\Digistore24\Api\Enum\RefundPendingReason;
use GoSuccess\Digistore24\Api\Enum\RefundStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Refund Transaction Response
 *
 * Response of refundTransaction. Mirrors the `data` object of the spec,
 * exposing the refund outcome, any pending state, and any error reason.
 *
 * @link https://digistore24.com/api/docs/paths/refundTransaction.yaml
 */
final class RefundTransactionResponse extends AbstractResponse
{
    /**
     * Result status.
     */
    public string $result = '';

    /**
     * Refund status (completed, refused, pending, error).
     */
    public ?RefundStatus $status = null;

    /**
     * Whether the transaction was modified (spec sends Y/N, exposed as bool).
     */
    public ?bool $modified = null;

    /**
     * Human-readable note about the refund outcome.
     */
    public ?string $note = null;

    /**
     * Reason why the refund is pending (default_delay, proof_missing,
     * proof_aproval, blocked).
     */
    public ?RefundPendingReason $pendingReason = null;

    /**
     * Pending reason in readable form.
     */
    public ?string $pendingReasonMsg = null;

    /**
     * Timestamp until which the refund stays pending.
     */
    public ?DateTimeImmutable $pendingUntil = null;

    /**
     * URL to act on a pending refund.
     */
    public ?string $actionUrl = null;

    /**
     * Reason why the refund failed (refund_completed, refund_pending, unknown).
     */
    public ?RefundErrorReason $errorReason = null;

    /**
     * Timestamp the refund was processed.
     */
    public ?DateTimeImmutable $processedAt = null;

    /**
     * The complete inner payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->status = RefundStatus::fromString(
            TypeConverter::toString($innerData['status'] ?? null),
        );
        $response->modified = TypeConverter::toBool($innerData['modified'] ?? null);
        $response->note = TypeConverter::toString($innerData['note'] ?? null);
        $response->pendingReason = RefundPendingReason::fromString(
            TypeConverter::toString($innerData['pending_reason'] ?? null),
        );
        $response->pendingReasonMsg = TypeConverter::toString($innerData['pending_reason_msg'] ?? null);
        $response->pendingUntil = TypeConverter::toDateTime($innerData['pending_until'] ?? null);
        $response->actionUrl = TypeConverter::toString($innerData['action_url'] ?? null);
        $response->errorReason = RefundErrorReason::fromString(
            TypeConverter::toString($innerData['error_reason'] ?? null),
        );
        $response->processedAt = TypeConverter::toDateTime($innerData['processed_at'] ?? null);
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
