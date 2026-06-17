<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Purchase;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Purchase\ListPurchasesResponse;
use PHPUnit\Framework\TestCase;

final class ListPurchasesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'purchases' => [
                [
                    'purchase_id' => 'P111111',
                    'product_id' => '100',
                    'product_name' => 'Course A',
                    'buyer_email' => 'buyer1@example.com',
                    'payment_status' => 'paid',
                    'amount' => 99.00,
                    'currency' => 'EUR',
                    'created_at' => '2024-01-10 10:00:00',
                    'click_id' => 'CLK1',
                    'sub_ids' => ['sid1' => 'a', 'sid2' => 'b'],
                ],
                [
                    'purchase_id' => 'P222222',
                    'product_id' => '200',
                    'product_name' => 'Course B',
                    'buyer_email' => 'buyer2@example.com',
                    'payment_status' => 'pending',
                    'amount' => 49.50,
                    'currency' => 'USD',
                    'created_at' => '2024-01-11 11:00:00',
                ],
            ],
            'total_count' => 2,
        ];
        $response = ListPurchasesResponse::fromArray($data);

        $this->assertInstanceOf(ListPurchasesResponse::class, $response);
        $this->assertCount(2, $response->purchases);
        $this->assertSame(2, $response->totalCount);
        $this->assertSame('P111111', $response->purchases[0]->purchaseId);
        $this->assertSame('Course A', $response->purchases[0]->productName);
        $this->assertSame('CLK1', $response->purchases[0]->clickId);
        $this->assertSame(['sid1' => 'a', 'sid2' => 'b'], $response->purchases[0]->subIds);
        $this->assertArrayHasKey('purchase_id', $response->purchases[0]->data);
        $this->assertNull($response->purchases[1]->clickId);
    }

    public function test_can_create_from_purchase_list_key(): void
    {
        $data = [
            'purchase_list' => [
                [
                    'purchase_id' => 'P900000',
                    'product_id' => '900',
                    'product_name' => 'Course Z',
                    'buyer_email' => 'buyerz@example.com',
                    'payment_status' => 'paid',
                    'amount' => 12.00,
                    'currency' => 'EUR',
                    'created_at' => '2024-03-01 09:00:00',
                ],
            ],
        ];
        $response = ListPurchasesResponse::fromArray($data);

        $this->assertCount(1, $response->purchases);
        $this->assertSame('P900000', $response->purchases[0]->purchaseId);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'purchases' => [
                    [
                        'purchase_id' => 'P333333',
                        'product_id' => '300',
                        'product_name' => 'Course C',
                        'buyer_email' => 'buyer3@example.com',
                        'payment_status' => 'paid',
                        'amount' => 79.99,
                        'currency' => 'EUR',
                        'created_at' => '2024-01-12 12:00:00',
                    ],
                ],
                'total_count' => 1,
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListPurchasesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListPurchasesResponse::class, $response);
        $this->assertCount(1, $response->purchases);
        $this->assertSame('P333333', $response->purchases[0]->purchaseId);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'purchases' => [],
                'total_count' => 0,
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = ListPurchasesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
