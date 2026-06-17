<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Delivery;

use GoSuccess\Digistore24\Api\DTO\DeliverySearchData;
use GoSuccess\Digistore24\Api\Request\Delivery\ListDeliveriesRequest;
use PHPUnit\Framework\TestCase;

final class ListDeliveriesRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new ListDeliveriesRequest();

        $this->assertInstanceOf(ListDeliveriesRequest::class, $request);
    }

    public function test_can_create_instance_with_search(): void
    {
        $request = new ListDeliveriesRequest(new DeliverySearchData(purchaseId: 'P12345'));

        $this->assertInstanceOf(ListDeliveriesRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new ListDeliveriesRequest();

        $this->assertSame('/listDeliveries', $request->getEndpoint());
    }

    public function test_to_array_returns_empty_array_without_search(): void
    {
        $request = new ListDeliveriesRequest();

        $array = $request->toArray();
        $this->assertEmpty($array);
    }

    public function test_to_array_includes_search_criteria_when_set(): void
    {
        $request = new ListDeliveriesRequest(
            new DeliverySearchData(
                purchaseId: 'P12345',
                type: 'delivery,partial_delivery',
                isProcessed: true,
                isTestOrder: false,
            ),
        );

        $array = $request->toArray();
        $this->assertIsArray($array['search']);
        /** @var array<string, mixed> $search */
        $search = $array['search'];
        $this->assertSame('P12345', $search['purchase_id']);
        $this->assertSame('delivery,partial_delivery', $search['type']);
        $this->assertTrue($search['is_processed']);
        $this->assertSame('N', $search['is_test_order']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new ListDeliveriesRequest();

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
