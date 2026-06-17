<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Affiliate;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Affiliate\UpdateAffiliateCommissionResponse;
use PHPUnit\Framework\TestCase;

final class UpdateAffiliateCommissionResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [],
        ];

        $response = UpdateAffiliateCommissionResponse::fromArray(data: $data);

        $this->assertInstanceOf(UpdateAffiliateCommissionResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame([], $response->data);
    }

    public function test_preserves_any_returned_data(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'note' => 'recreated',
            ],
        ];

        $response = UpdateAffiliateCommissionResponse::fromArray(data: $data);

        $this->assertInstanceOf(UpdateAffiliateCommissionResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame('recreated', $response->data['note']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = UpdateAffiliateCommissionResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(UpdateAffiliateCommissionResponse::class, $response);
        $this->assertSame('success', $response->result);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = UpdateAffiliateCommissionResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
