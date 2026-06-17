<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Buyer;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Buyer\UpdateBuyerResponse;
use PHPUnit\Framework\TestCase;

final class UpdateBuyerResponseTest extends TestCase
{
    public function test_can_create_from_array_modified(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'is_modified' => 'Y',
            ],
        ];

        $response = UpdateBuyerResponse::fromArray($data);

        $this->assertInstanceOf(UpdateBuyerResponse::class, $response);
        $this->assertTrue($response->isModified);
        $this->assertSame('success', $response->result);
    }

    public function test_can_create_from_array_not_modified(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'is_modified' => 'N',
            ],
        ];

        $response = UpdateBuyerResponse::fromArray($data);

        $this->assertFalse($response->isModified);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'is_modified' => 'Y',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = UpdateBuyerResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(UpdateBuyerResponse::class, $response);
        $this->assertTrue($response->isModified);
    }

    public function test_handles_missing_data(): void
    {
        $data = ['data' => []];

        $response = UpdateBuyerResponse::fromArray($data);

        $this->assertNull($response->isModified);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = UpdateBuyerResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
