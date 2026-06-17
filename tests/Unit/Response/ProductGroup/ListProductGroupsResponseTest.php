<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ProductGroup;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ProductGroup\ListProductGroupsResponse;
use PHPUnit\Framework\TestCase;

final class ListProductGroupsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'product_groups' => [
                    [
                        'id' => 101,
                        'name' => 'Group A',
                        'created_at' => '2024-01-01 10:00:00',
                        'modified_at' => '2024-01-02 11:00:00',
                    ],
                    [
                        'id' => 102,
                        'name' => 'Group B',
                    ],
                ],
            ],
        ];
        $response = ListProductGroupsResponse::fromArray($data);

        $this->assertInstanceOf(ListProductGroupsResponse::class, $response);
        $this->assertCount(2, $response->productGroups);
        $this->assertSame(101, $response->productGroups[0]->id);
        $this->assertSame('Group A', $response->productGroups[0]->name);
        $this->assertSame('2024-01-01 10:00:00', $response->productGroups[0]->createdAt?->format('Y-m-d H:i:s'));
        $this->assertSame('2024-01-02 11:00:00', $response->productGroups[0]->modifiedAt?->format('Y-m-d H:i:s'));
    }

    public function test_can_create_from_bare_array_payload(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    [
                        'id' => 201,
                        'name' => 'Group C',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListProductGroupsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListProductGroupsResponse::class, $response);
        $this->assertCount(1, $response->productGroups);
        $this->assertSame(201, $response->productGroups[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = ListProductGroupsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
