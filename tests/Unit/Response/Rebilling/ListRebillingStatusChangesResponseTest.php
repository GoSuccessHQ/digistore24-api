<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Rebilling;

use GoSuccess\Digistore24\Api\DTO\RebillingStatusChangeData;
use GoSuccess\Digistore24\Api\Enum\RebillingStatusChangeType;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Rebilling\ListRebillingStatusChangesResponse;
use PHPUnit\Framework\TestCase;

final class ListRebillingStatusChangesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'from' => '2024-01-01 00:00:00',
                'to' => '2024-02-01 00:00:00',
                'items' => [
                    [
                        'id' => 1,
                        'purchase_id' => 'P123456',
                        'created_at' => '2024-01-15 10:00:00',
                        'pay_sequence_no' => 2,
                        'type' => 'rebill_cancelled',
                        'type_msg' => 'Rebilling cancelled',
                    ],
                    [
                        'id' => 2,
                        'purchase_id' => 'P123456',
                        'created_at' => '2024-02-01 12:00:00',
                        'pay_sequence_no' => 3,
                        'type' => 'rebill_resumed',
                        'type_msg' => 'Rebilling resumed',
                    ],
                ],
                'page_size' => 100,
                'page_no' => 1,
                'page_count' => 1,
                'item_count' => 2,
            ],
        ];
        $response = ListRebillingStatusChangesResponse::fromArray($data);

        $this->assertInstanceOf(ListRebillingStatusChangesResponse::class, $response);
        $this->assertCount(2, $response->items);
        $this->assertInstanceOf(RebillingStatusChangeData::class, $response->items[0]);
        $this->assertSame(1, $response->items[0]->id);
        $this->assertSame('P123456', $response->items[0]->purchaseId);
        $this->assertSame(2, $response->items[0]->paySequenceNo);
        $this->assertSame(RebillingStatusChangeType::REBILL_CANCELLED, $response->items[0]->type);
        $this->assertSame('2024-01-01 00:00:00', $response->from);
        $this->assertSame(1, $response->pageNo);
        $this->assertSame(2, $response->itemCount);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'items' => [
                        [
                            'id' => 999,
                            'purchase_id' => 'P999999',
                            'type' => 'last_paid_day',
                        ],
                    ],
                    'item_count' => 1,
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListRebillingStatusChangesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListRebillingStatusChangesResponse::class, $response);
        $this->assertCount(1, $response->items);
        $this->assertSame(RebillingStatusChangeType::LAST_PAID_DAY, $response->items[0]->type);
        $this->assertSame(1, $response->itemCount);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'items' => [],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = ListRebillingStatusChangesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
