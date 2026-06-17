<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Affiliate;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Affiliate\GetAffiliateForEmailResponse;
use PHPUnit\Framework\TestCase;

final class GetAffiliateForEmailResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'affiliate_name' => 'some_affiliate',
                'affiliate_id' => 123,
                'campaignkey' => 'some-campaignkey',
                'trackingkey' => 'some-trackingkey',
                'click_id' => 'some-clickid',
                'promoclick_at' => '2022-09-16 19:30:10',
            ],
        ];

        $response = GetAffiliateForEmailResponse::fromArray(data: $data);

        $this->assertInstanceOf(GetAffiliateForEmailResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame('some_affiliate', $response->affiliateName);
        $this->assertSame(123, $response->affiliateId);
        $this->assertSame('some-campaignkey', $response->campaignkey);
        $this->assertSame('some-trackingkey', $response->trackingkey);
        $this->assertSame('some-clickid', $response->clickId);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->promoclickAt);
        $this->assertSame('some-campaignkey', $response->data['campaignkey']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'affiliate_name' => 'jane_affiliate',
                    'affiliate_id' => 456,
                    'campaignkey' => 'camp-456',
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = GetAffiliateForEmailResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(GetAffiliateForEmailResponse::class, $response);
        $this->assertSame('jane_affiliate', $response->affiliateName);
        $this->assertSame(456, $response->affiliateId);
        $this->assertSame('camp-456', $response->campaignkey);
        $this->assertNull($response->trackingkey);
        $this->assertNull($response->promoclickAt);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => ['affiliate_id' => 123, 'affiliate_name' => 'test'],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = GetAffiliateForEmailResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
