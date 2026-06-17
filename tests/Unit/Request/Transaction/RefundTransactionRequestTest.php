<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Transaction;

use GoSuccess\Digistore24\Api\Request\Transaction\RefundTransactionRequest;
use PHPUnit\Framework\TestCase;

final class RefundTransactionRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new RefundTransactionRequest(transactionId: 'T12345');

        $this->assertInstanceOf(RefundTransactionRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new RefundTransactionRequest(transactionId: 'T12345');

        $this->assertSame('/refundTransaction', $request->getEndpoint());
    }

    public function test_to_array_includes_transaction_id(): void
    {
        $request = new RefundTransactionRequest(transactionId: 'T12345', force: true);

        $array = $request->toArray();
        $this->assertSame('T12345', $array['transaction_id']);
        $this->assertSame('Y', $array['force']);
    }

    public function test_to_array_omits_optional_params_when_not_set(): void
    {
        $request = new RefundTransactionRequest(transactionId: 'T12345');

        $array = $request->toArray();
        $this->assertSame(['transaction_id' => 'T12345'], $array);
    }

    public function test_to_array_includes_force_no_and_request_date(): void
    {
        $request = new RefundTransactionRequest(
            transactionId: 'T98765',
            force: false,
            requestDate: '2024-06-01',
        );

        $array = $request->toArray();
        $this->assertSame('N', $array['force']);
        $this->assertSame('2024-06-01', $array['request_date']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new RefundTransactionRequest(transactionId: 'T12345');

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
