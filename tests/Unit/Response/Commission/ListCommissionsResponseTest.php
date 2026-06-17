<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Commission;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Commission\ListCommissionsResponse;
use PHPUnit\Framework\TestCase;

final class ListCommissionsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'page_no' => 1,
            'page_size' => 10,
            'item_count' => 25,
            'page_count' => 3,
            'items' => [
                [
                    'id' => 1,
                    'created_at' => '2024-01-01 10:00:00',
                    'amount' => 50.00,
                    'currency' => 'EUR',
                    'reason' => 'Sale commission',
                    'schedule_payout_at' => '2024-02-01',
                    'transaction_id' => 100,
                    'purchase_id' => 'P123',
                ],
                [
                    'id' => 2,
                    'amount' => 25.50,
                    'currency' => 'EUR',
                ],
            ],
        ];
        $response = ListCommissionsResponse::fromArray($data);

        $this->assertInstanceOf(ListCommissionsResponse::class, $response);
        $this->assertSame(1, $response->pageNo);
        $this->assertSame(10, $response->pageSize);
        $this->assertSame(25, $response->itemCount);
        $this->assertSame(3, $response->pageCount);
        $this->assertCount(2, $response->items);
        $this->assertTrue($response->hasMorePages());

        $first = $response->items[0];
        $this->assertSame(1, $first->id);
        $this->assertInstanceOf(\DateTimeImmutable::class, $first->createdAt);
        $this->assertSame(50.00, $first->amount);
        $this->assertSame('EUR', $first->currency);
        $this->assertSame('Sale commission', $first->reason);
        $this->assertSame('2024-02-01', $first->schedulePayoutAt);
        $this->assertSame(100, $first->transactionId);
        $this->assertSame('P123', $first->purchaseId);

        $this->assertSame(75.50, $response->getTotalAmount());
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'page_no' => 1,
                'page_size' => 10,
                'item_count' => 25,
                'page_count' => 3,
                'items' => [],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListCommissionsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListCommissionsResponse::class, $response);
        $this->assertSame(1, $response->pageNo);
        $this->assertCount(0, $response->items);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListCommissionsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
