<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Affiliate;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Affiliate\GetReferringAffiliateResponse;
use PHPUnit\Framework\TestCase;

final class GetReferringAffiliateResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'affiliate_id' => 789,
                'affiliate_name' => 'John Doe',
                'referrer_id' => 321,
                'referrer_name' => 'Referring Partner',
                'commission' => 50.0,
                'created_at' => '2025-10-15 10:30:00',
                'created_by' => 12,
            ],
        ];

        $response = GetReferringAffiliateResponse::fromArray(data: $data);

        $this->assertInstanceOf(GetReferringAffiliateResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame(789, $response->affiliateId);
        $this->assertSame('John Doe', $response->affiliateName);
        $this->assertSame(321, $response->referrerId);
        $this->assertSame('Referring Partner', $response->referrerName);
        $this->assertSame(50.0, $response->commission);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->createdAt);
        $this->assertSame(12, $response->createdBy);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'affiliate_id' => 456,
                    'affiliate_name' => 'Jane Smith',
                    'referrer_id' => 654,
                    'referrer_name' => 'Partner Inc',
                    'commission' => 25.5,
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = GetReferringAffiliateResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(GetReferringAffiliateResponse::class, $response);
        $this->assertSame(456, $response->affiliateId);
        $this->assertSame('Jane Smith', $response->affiliateName);
        $this->assertSame(654, $response->referrerId);
        $this->assertSame(25.5, $response->commission);
    }

    public function test_handles_no_affiliate(): void
    {
        $data = [
            'result' => 'success',
            'data' => [],
        ];

        $response = GetReferringAffiliateResponse::fromArray(data: $data);

        $this->assertInstanceOf(GetReferringAffiliateResponse::class, $response);
        $this->assertNull($response->affiliateId);
        $this->assertNull($response->affiliateName);
        $this->assertNull($response->referrerId);
        $this->assertNull($response->referrerName);
        $this->assertNull($response->commission);
        $this->assertNull($response->createdAt);
        $this->assertNull($response->createdBy);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => ['affiliate_id' => 123],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = GetReferringAffiliateResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
