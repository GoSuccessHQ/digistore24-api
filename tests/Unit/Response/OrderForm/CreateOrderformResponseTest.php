<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\OrderForm;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\OrderForm\CreateOrderformResponse;
use PHPUnit\Framework\TestCase;

final class CreateOrderformResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'orderform_id' => 123456,
            ],
        ];
        $response = CreateOrderformResponse::fromArray($data);

        $this->assertInstanceOf(CreateOrderformResponse::class, $response);
        $this->assertSame(123456, $response->orderformId);
        $this->assertSame('123456', $response->getOrderformId());
        $this->assertTrue($response->wasSuccessful());
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'data' => [
                        'orderform_id' => 789012,
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = CreateOrderformResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(CreateOrderformResponse::class, $response);
        $this->assertSame(789012, $response->orderformId);
        $this->assertSame('789012', $response->getOrderformId());
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = CreateOrderformResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
