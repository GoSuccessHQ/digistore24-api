<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Ipn;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Ipn\IpnInfoResponse;
use PHPUnit\Framework\TestCase;

final class IpnInfoResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'url' => 'https://example.com/webhook',
                'name' => 'My Platform',
                'product_ids' => 'all',
                'domain_id' => 'my-platform',
                'transactions' => 'payment,refund',
                'timing' => 'before_thankyou',
                'newsletter_send_policy' => 'send_always',
            ],
        ];
        $response = IpnInfoResponse::fromArray($data);

        $this->assertInstanceOf(IpnInfoResponse::class, $response);
        $this->assertSame('https://example.com/webhook', $response->url);
        $this->assertSame('My Platform', $response->name);
        $this->assertSame('all', $response->productIds);
        $this->assertSame('my-platform', $response->domainId);
        $this->assertSame('payment,refund', $response->transactions);
        $this->assertSame('before_thankyou', $response->timing);
        $this->assertSame('send_always', $response->newsletterSendPolicy);
        $this->assertArrayHasKey('url', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'url' => 'https://api.example.com/notifications',
                    'ipn_id' => 'IPN012',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = IpnInfoResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(IpnInfoResponse::class, $response);
        $this->assertSame('https://api.example.com/notifications', $response->url);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = IpnInfoResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
