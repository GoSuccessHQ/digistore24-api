<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\BuyUrl;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Enum\UpgradeStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\BuyUrl\CreateBuyUrlResponse;
use PHPUnit\Framework\TestCase;

final class CreateBuyUrlResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'id' => 'BU12345',
                'url' => 'https://www.digistore24.com/buy/12345/abc123',
                'valid_until' => '2024-12-31 23:59:59',
                'upgrade_status' => 'ok',
            ],
        ];

        $response = CreateBuyUrlResponse::fromArray(data: $data);

        $this->assertInstanceOf(CreateBuyUrlResponse::class, $response);
        $this->assertSame('BU12345', $response->id);
        $this->assertSame('https://www.digistore24.com/buy/12345/abc123', $response->url);
        $this->assertInstanceOf(DateTimeImmutable::class, $response->validUntil);
        $this->assertSame('2024-12-31 23:59:59', $response->validUntil->format('Y-m-d H:i:s'));
        $this->assertSame(UpgradeStatus::OK, $response->upgradeStatus);
        $this->assertSame('BU12345', $response->data['id']);
    }

    public function test_can_create_with_upgrade_error(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'id' => 'BU99999',
                'url' => 'https://www.digistore24.com/buy/99999/xyz789',
                'valid_until' => '2025-01-15 12:00:00',
                'upgrade_status' => 'error',
            ],
        ];

        $response = CreateBuyUrlResponse::fromArray(data: $data);

        $this->assertInstanceOf(CreateBuyUrlResponse::class, $response);
        $this->assertSame(UpgradeStatus::ERROR, $response->upgradeStatus);
    }

    public function test_can_create_with_no_upgrade(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'id' => 'BU77777',
                'url' => 'https://www.digistore24.com/buy/77777/def456',
                'upgrade_status' => 'none',
            ],
        ];

        $response = CreateBuyUrlResponse::fromArray(data: $data);

        $this->assertInstanceOf(CreateBuyUrlResponse::class, $response);
        $this->assertSame(UpgradeStatus::NONE, $response->upgradeStatus);
        $this->assertNull($response->validUntil);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'id' => 'BU54321',
                    'url' => 'https://www.digistore24.com/buy/54321/token123',
                    'valid_until' => '2024-11-20 18:30:00',
                    'upgrade_status' => 'ok',
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = CreateBuyUrlResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(CreateBuyUrlResponse::class, $response);
        $this->assertSame('BU54321', $response->id);
        $this->assertSame('https://www.digistore24.com/buy/54321/token123', $response->url);
        $this->assertSame(UpgradeStatus::OK, $response->upgradeStatus);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'id' => 'BU123',
                    'url' => 'https://test.com',
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = CreateBuyUrlResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
