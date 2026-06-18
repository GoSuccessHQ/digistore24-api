<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Purchase;

use GoSuccess\Digistore24\Api\Request\Purchase\UpdatePurchaseRequest;
use PHPUnit\Framework\TestCase;

final class UpdatePurchaseRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new UpdatePurchaseRequest(purchaseId: 'P12345');

        $this->assertInstanceOf(UpdatePurchaseRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new UpdatePurchaseRequest(purchaseId: 'P12345');

        $this->assertSame('/updatePurchase', $request->getEndpoint());
    }

    public function test_to_array_includes_purchase_id_and_optional_fields(): void
    {
        $request = new UpdatePurchaseRequest(
            purchaseId: 'P12345',
            custom: 'ref-123',
            unlockInvoices: true,
        );

        $array = $request->toArray();
        $this->assertSame('P12345', $array['purchase_id']);
        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame('ref-123', $data['custom']);
        $this->assertSame('Y', $data['unlock_invoices']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new UpdatePurchaseRequest(purchaseId: 'P12345');

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
