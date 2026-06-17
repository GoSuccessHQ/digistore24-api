<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ApiKey;

use GoSuccess\Digistore24\Api\Enum\ApiRequestStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ApiKey\RetrieveApiKeyResponse;
use PHPUnit\Framework\TestCase;

final class RetrieveApiKeyResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'api_key' => 'live-api-key-12345',
                'request_status' => 'completed',
                'note' => 'API key created successfully.',
            ],
        ];

        $response = RetrieveApiKeyResponse::fromArray(data: $data);

        $this->assertInstanceOf(RetrieveApiKeyResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame('live-api-key-12345', $response->apiKey);
        $this->assertSame(ApiRequestStatus::COMPLETED, $response->requestStatus);
        $this->assertSame('API key created successfully.', $response->note);
        $this->assertSame('live-api-key-12345', $response->data['api_key']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'api_key' => '',
                    'request_status' => 'pending',
                    'note' => 'The user has not confirmed yet.',
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = RetrieveApiKeyResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(RetrieveApiKeyResponse::class, $response);
        $this->assertSame('', $response->apiKey);
        $this->assertSame(ApiRequestStatus::PENDING, $response->requestStatus);
        $this->assertSame('The user has not confirmed yet.', $response->note);
    }

    public function test_handles_aborted_status(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'api_key' => '',
                'request_status' => 'aborted',
                'note' => 'The user canceled the request.',
            ],
        ];

        $response = RetrieveApiKeyResponse::fromArray(data: $data);

        $this->assertInstanceOf(RetrieveApiKeyResponse::class, $response);
        $this->assertSame('', $response->apiKey);
        $this->assertSame(ApiRequestStatus::ABORTED, $response->requestStatus);
        $this->assertSame('The user canceled the request.', $response->note);
    }

    public function test_handles_minimal_data(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'api_key' => 'minimal-key',
            ],
        ];

        $response = RetrieveApiKeyResponse::fromArray(data: $data);

        $this->assertInstanceOf(RetrieveApiKeyResponse::class, $response);
        $this->assertSame('minimal-key', $response->apiKey);
        $this->assertNull($response->requestStatus);
        $this->assertNull($response->note);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => ['api_key' => 'TEST', 'request_status' => 'completed'],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = RetrieveApiKeyResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
