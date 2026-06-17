<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ProductGroup\CreateProductGroupResponse;
use PHPUnit\Framework\TestCase;

final class CreateProductGroupResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'product_group_id' => 123456,
            ],
        ];
        $response = CreateProductGroupResponse::fromArray($data);

        $this->assertInstanceOf(CreateProductGroupResponse::class, $response);
        $this->assertSame(123456, $response->productGroupId);
        $this->assertSame('123456', $response->getProductGroupId());
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'product_group_id' => 789012,
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = CreateProductGroupResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(CreateProductGroupResponse::class, $response);
        $this->assertSame(789012, $response->productGroupId);
        $this->assertSame('789012', $response->getProductGroupId());
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = CreateProductGroupResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
