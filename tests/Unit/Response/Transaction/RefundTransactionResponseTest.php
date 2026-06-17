<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Transaction;

use GoSuccess\Digistore24\Api\Enum\RefundErrorReason;
use GoSuccess\Digistore24\Api\Enum\RefundPendingReason;
use GoSuccess\Digistore24\Api\Enum\RefundStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Transaction\RefundTransactionResponse;
use PHPUnit\Framework\TestCase;

final class RefundTransactionResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'status' => 'completed',
                'modified' => 'Y',
                'note' => 'Refund processed.',
                'processed_at' => '2024-01-15 09:00:00',
            ],
        ];
        $response = RefundTransactionResponse::fromArray($data);

        $this->assertInstanceOf(RefundTransactionResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame(RefundStatus::COMPLETED, $response->status);
        $this->assertTrue($response->modified);
        $this->assertSame('Refund processed.', $response->note);
        $this->assertInstanceOf(\DateTimeImmutable::class, $response->processedAt);
        $this->assertSame('2024-01-15 09:00:00', $response->processedAt->format('Y-m-d H:i:s'));
    }

    public function test_modified_n_is_false(): void
    {
        $data = [
            'data' => [
                'status' => 'refused',
                'modified' => 'N',
            ],
        ];
        $response = RefundTransactionResponse::fromArray($data);

        $this->assertSame(RefundStatus::REFUSED, $response->status);
        $this->assertFalse($response->modified);
    }

    public function test_pending_fields_are_typed(): void
    {
        $data = [
            'data' => [
                'status' => 'pending',
                'modified' => 'N',
                'pending_reason' => 'proof_missing',
                'pending_reason_msg' => 'Proof is missing.',
                'pending_until' => '2024-02-01 00:00:00',
                'action_url' => 'https://www.digistore24.com/action/123',
            ],
        ];
        $response = RefundTransactionResponse::fromArray($data);

        $this->assertSame(RefundStatus::PENDING, $response->status);
        $this->assertSame(RefundPendingReason::PROOF_MISSING, $response->pendingReason);
        $this->assertSame('Proof is missing.', $response->pendingReasonMsg);
        $this->assertInstanceOf(\DateTimeImmutable::class, $response->pendingUntil);
        $this->assertSame('2024-02-01 00:00:00', $response->pendingUntil->format('Y-m-d H:i:s'));
        $this->assertSame('https://www.digistore24.com/action/123', $response->actionUrl);
    }

    public function test_error_reason_is_typed(): void
    {
        $data = [
            'data' => [
                'status' => 'error',
                'modified' => 'N',
                'error_reason' => 'refund_completed',
            ],
        ];
        $response = RefundTransactionResponse::fromArray($data);

        $this->assertSame(RefundStatus::ERROR, $response->status);
        $this->assertSame(RefundErrorReason::REFUND_COMPLETED, $response->errorReason);
    }

    public function test_data_holds_full_inner_payload(): void
    {
        $data = [
            'data' => [
                'status' => 'completed',
                'modified' => 'Y',
                'note' => 'Done.',
            ],
        ];
        $response = RefundTransactionResponse::fromArray($data);

        $this->assertSame('Done.', $response->data['note']);
        $this->assertSame('completed', $response->data['status']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'status' => 'completed',
                    'modified' => 'Y',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = RefundTransactionResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(RefundTransactionResponse::class, $response);
        $this->assertSame(RefundStatus::COMPLETED, $response->status);
        $this->assertTrue($response->modified);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'status' => 'completed',
                    'modified' => 'Y',
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = RefundTransactionResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
