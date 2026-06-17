<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Delivery;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Delivery\UpdateDeliveryResponse;
use PHPUnit\Framework\TestCase;

final class UpdateDeliveryResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = ['result' => 'success', 'data' => ['is_modified' => 'Y']];
        $response = UpdateDeliveryResponse::fromArray($data);

        $this->assertInstanceOf(UpdateDeliveryResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertTrue($response->isModified);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['result' => 'success', 'data' => ['is_modified' => 'N']],
            headers: [],
            rawBody: '',
        );

        $response = UpdateDeliveryResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(UpdateDeliveryResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertFalse($response->isModified);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['result' => 'success'],
            headers: [],
            rawBody: 'test',
        );

        $response = UpdateDeliveryResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
