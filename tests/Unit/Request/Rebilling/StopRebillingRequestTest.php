<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Rebilling;

use GoSuccess\Digistore24\Api\Request\Rebilling\StopRebillingRequest;
use PHPUnit\Framework\TestCase;

final class StopRebillingRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new StopRebillingRequest(purchaseId: 'P12345');

        $this->assertInstanceOf(StopRebillingRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new StopRebillingRequest(purchaseId: 'P12345');

        $this->assertSame('/stopRebilling', $request->getEndpoint());
    }

    public function test_to_array_includes_purchase_id(): void
    {
        $request = new StopRebillingRequest(purchaseId: 'P12345');

        $array = $request->toArray();
        $this->assertSame('P12345', $array['purchase_id']);
        $this->assertArrayNotHasKey('force', $array);
        $this->assertArrayNotHasKey('ignore_refund_possibility', $array);
    }

    public function test_to_array_includes_flags_when_set(): void
    {
        $request = new StopRebillingRequest(
            purchaseId: 'P12345',
            force: true,
            ignoreRefundPossibility: false,
        );

        $array = $request->toArray();
        $this->assertSame('P12345', $array['purchase_id']);
        $this->assertSame('Y', $array['force']);
        $this->assertSame('N', $array['ignore_refund_possibility']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new StopRebillingRequest(purchaseId: 'P12345');

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
