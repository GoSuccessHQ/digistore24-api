<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ApiKey;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ApiKey\RequestApiKeyResponse;
use PHPUnit\Framework\TestCase;

final class RequestApiKeyResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'request_url' => 'https://www.digistore24.com/api-key-request/abc123',
                'request_token' => 'request-token-12345',
            ],
        ];

        $response = RequestApiKeyResponse::fromArray(data: $data);

        $this->assertInstanceOf(RequestApiKeyResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame('https://www.digistore24.com/api-key-request/abc123', $response->requestUrl);
        $this->assertSame('request-token-12345', $response->requestToken);
        $this->assertSame('https://www.digistore24.com/api-key-request/abc123', $response->data['request_url']);
        $this->assertSame('request-token-12345', $response->data['request_token']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'request_url' => 'https://www.digistore24.com/api-key-request/xyz789',
                    'request_token' => 'request-token-67890',
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = RequestApiKeyResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(RequestApiKeyResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame('https://www.digistore24.com/api-key-request/xyz789', $response->requestUrl);
        $this->assertSame('request-token-67890', $response->requestToken);
    }

    public function test_handles_minimal_data(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'request_token' => 'minimal-token',
            ],
        ];

        $response = RequestApiKeyResponse::fromArray(data: $data);

        $this->assertInstanceOf(RequestApiKeyResponse::class, $response);
        $this->assertSame('minimal-token', $response->requestToken);
        $this->assertNull($response->requestUrl);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => ['request_token' => 'test-token'],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = RequestApiKeyResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
