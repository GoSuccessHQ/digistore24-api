<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Delivery;

use GoSuccess\Digistore24\Api\DTO\DeliveryData;
use GoSuccess\Digistore24\Api\DTO\DeliveryTrackingUpdateData;
use GoSuccess\Digistore24\Api\Enum\DeliveryStatus;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Request\Delivery\UpdateDeliveryRequest;
use PHPUnit\Framework\TestCase;

final class UpdateDeliveryRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $delivery = new DeliveryData();
        $delivery->type = DeliveryStatus::DELIVERY;

        $request = new UpdateDeliveryRequest(
            deliveryId: 'D12345',
            delivery: $delivery,
        );

        $this->assertInstanceOf(UpdateDeliveryRequest::class, $request);
    }

    public function test_endpoint_and_method(): void
    {
        $request = new UpdateDeliveryRequest(
            deliveryId: 'D12345',
            delivery: new DeliveryData(),
        );

        $this->assertSame('/updateDelivery', $request->getEndpoint());
        $this->assertSame(HttpMethod::PUT, $request->getMethod());
    }

    public function test_to_array_wraps_status_in_data_object(): void
    {
        $delivery = new DeliveryData();
        $delivery->type = DeliveryStatus::DELIVERY;
        $delivery->isShipped = true;

        $request = new UpdateDeliveryRequest(
            deliveryId: 'D12345',
            delivery: $delivery,
        );

        $array = $request->toArray();
        $this->assertSame('D12345', $array['delivery_id']);
        $this->assertSame('Y', $array['notify_via_email']);
        $this->assertArrayNotHasKey('tracking', $array);

        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame('delivery', $data['type']);
        $this->assertSame('Y', $data['is_shipped']);
    }

    public function test_to_array_includes_tracking_entries(): void
    {
        $delivery = new DeliveryData();
        $delivery->type = DeliveryStatus::DELIVERY;

        $request = new UpdateDeliveryRequest(
            deliveryId: 'D12345',
            delivery: $delivery,
            tracking: [
                new DeliveryTrackingUpdateData(parcelService: 'ups', trackingId: '1Z999'),
            ],
            notifyViaEmail: false,
        );

        $array = $request->toArray();
        $this->assertSame('N', $array['notify_via_email']);

        $tracking = $array['tracking'];
        $this->assertIsArray($tracking);
        $this->assertCount(1, $tracking);

        $first = $tracking[0];
        $this->assertIsArray($first);
        $this->assertSame('ups', $first['parcel_service']);
        $this->assertSame('1Z999', $first['tracking_id']);
        $this->assertSame('create_or_update', $first['operation']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new UpdateDeliveryRequest(
            deliveryId: 'D12345',
            delivery: new DeliveryData(),
        );

        $this->assertEmpty($request->validate());
    }
}
