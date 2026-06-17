<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Purchase;

use GoSuccess\Digistore24\Api\Request\Purchase\RefundPartiallyRequest;
use PHPUnit\Framework\TestCase;

final class RefundPartiallyRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new RefundPartiallyRequest(purchaseId: 'P12345', amount: 15.50);

        $this->assertInstanceOf(RefundPartiallyRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new RefundPartiallyRequest(purchaseId: 'P12345', amount: 15.50);

        $this->assertSame('/refundPartially', $request->getEndpoint());
    }

    public function test_to_array_includes_purchase_id_and_amount(): void
    {
        $request = new RefundPartiallyRequest(purchaseId: 'P12345', amount: 15.50);

        $array = $request->toArray();
        $this->assertSame('P12345', $array['purchase_id']);
        $this->assertSame(15.50, $array['amount']);
        $this->assertArrayNotHasKey('reason', $array);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new RefundPartiallyRequest(purchaseId: 'P12345', amount: 15.50);

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
