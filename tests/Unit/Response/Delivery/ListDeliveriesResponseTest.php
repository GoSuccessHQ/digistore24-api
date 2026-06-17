<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Delivery;

use GoSuccess\Digistore24\Api\DTO\DeliveryDetailsData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Delivery\ListDeliveriesResponse;
use PHPUnit\Framework\TestCase;

final class ListDeliveriesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'deliveries' => [
                    ['id' => 1, 'purchase_id' => 'P001', 'type' => 'delivery'],
                    ['id' => 2, 'purchase_id' => 'P002', 'type' => 'request'],
                ],
            ],
        ];
        $response = ListDeliveriesResponse::fromArray($data);

        $this->assertInstanceOf(ListDeliveriesResponse::class, $response);
        $this->assertCount(2, $response->deliveries);
        $first = $response->deliveries[0];
        $this->assertInstanceOf(DeliveryDetailsData::class, $first);
        $this->assertSame(1, $first->id);
        $this->assertSame('P001', $first->purchaseId);
        $this->assertSame('delivery', $first->type);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'deliveries' => [
                        ['id' => 1, 'purchase_id' => 'P001'],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListDeliveriesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListDeliveriesResponse::class, $response);
        $this->assertCount(1, $response->deliveries);
        $this->assertSame(1, $response->deliveries[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = ListDeliveriesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
