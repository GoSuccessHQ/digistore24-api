<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\OrderForm;

use GoSuccess\Digistore24\Api\DTO\OrderformListItemData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\OrderForm\ListOrderformsResponse;
use PHPUnit\Framework\TestCase;

final class ListOrderformsResponseTest extends TestCase
{
    public function test_can_create_from_bare_array(): void
    {
        $data = [
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Standard Form',
                    'created_at' => '2024-01-15 10:00:00',
                    'modified_at' => '2024-02-01 12:00:00',
                ],
                [
                    'id' => 2,
                    'name' => 'Premium Form',
                    'created_at' => '2024-03-01 09:00:00',
                    'modified_at' => '2024-03-05 09:00:00',
                ],
            ],
        ];
        $response = ListOrderformsResponse::fromArray($data);

        $this->assertInstanceOf(ListOrderformsResponse::class, $response);
        $this->assertCount(2, $response->orderforms);
        $this->assertInstanceOf(OrderformListItemData::class, $response->orderforms[0]);
        $this->assertSame(1, $response->orderforms[0]->id);
        $this->assertSame('Standard Form', $response->orderforms[0]->name);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->orderforms[0]->createdAt);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    [
                        'id' => 3,
                        'name' => 'Basic Form',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListOrderformsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListOrderformsResponse::class, $response);
        $this->assertCount(1, $response->orderforms);
        $this->assertSame('Basic Form', $response->orderforms[0]->name);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListOrderformsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
