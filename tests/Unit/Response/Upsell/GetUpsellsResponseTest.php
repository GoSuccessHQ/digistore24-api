<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Upsell;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Upsell\GetUpsellsResponse;
use PHPUnit\Framework\TestCase;

final class GetUpsellsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'product_id' => 100,
                'upsells' => [
                    'y' => 200,
                    'yn' => 300,
                    'yy' => 400,
                ],
                'product_options' => [
                    '200' => ['orderform_id' => 5],
                ],
            ],
        ];
        $response = GetUpsellsResponse::fromArray($data);

        $this->assertInstanceOf(GetUpsellsResponse::class, $response);
        $this->assertSame(100, $response->productId);
        $this->assertCount(3, $response->upsells);
        $this->assertSame(200, $response->upsells['y']);
        $this->assertSame(300, $response->upsells['yn']);
        $this->assertArrayHasKey('200', $response->productOptions);
        $this->assertArrayHasKey('upsells', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'product_id' => 999,
                    'upsells' => [
                        'y' => 1000,
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetUpsellsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetUpsellsResponse::class, $response);
        $this->assertSame(999, $response->productId);
        $this->assertCount(1, $response->upsells);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'upsells' => [],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = GetUpsellsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
