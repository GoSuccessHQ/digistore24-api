<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Purchase;

use GoSuccess\Digistore24\Api\DTO\PurchaseOfEmailData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Purchase\ListPurchasesOfEmailResponse;
use PHPUnit\Framework\TestCase;

final class ListPurchasesOfEmailResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                [
                    'id' => 'P111',
                    'created_at' => '2024-01-10 10:00:00',
                    'amount' => 99.99,
                    'currency' => 'EUR',
                    'status' => 'paid',
                ],
                [
                    'id' => 'P222',
                    'created_at' => '2024-01-11 11:00:00',
                    'amount' => 49.50,
                    'currency' => 'USD',
                    'status' => 'pending',
                ],
            ],
        ];
        $response = ListPurchasesOfEmailResponse::fromArray($data);

        $this->assertInstanceOf(ListPurchasesOfEmailResponse::class, $response);
        $this->assertCount(2, $response->purchases);
        $this->assertInstanceOf(PurchaseOfEmailData::class, $response->purchases[0]);
        $this->assertSame('P111', $response->purchases[0]->id);
        $this->assertSame(99.99, $response->purchases[0]->amount);
        $this->assertSame('EUR', $response->purchases[0]->currency);
        $this->assertSame('paid', $response->purchases[0]->status);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->purchases[0]->createdAt);
        $this->assertSame('P222', $response->purchases[1]->id);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'data' => [
                        [
                            'id' => 'P333',
                            'amount' => 79.99,
                            'currency' => 'EUR',
                            'status' => 'paid',
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListPurchasesOfEmailResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListPurchasesOfEmailResponse::class, $response);
        $this->assertCount(1, $response->purchases);
        $this->assertSame('P333', $response->purchases[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = ListPurchasesOfEmailResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
