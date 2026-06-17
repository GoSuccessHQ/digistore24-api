<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Affiliate;

use GoSuccess\Digistore24\Api\Enum\ReferringAffiliateAction;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Affiliate\SetReferringAffiliateResponse;
use PHPUnit\Framework\TestCase;

final class SetReferringAffiliateResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'action' => 'create',
                'affiliate_id' => '789',
                'affiliate_name' => 'affiliate_user',
                'referrer_id' => '321',
                'referrer_name' => 'referrer_user',
                'commission' => 25.5,
                'created_at' => '2025-10-15 14:30:00',
                'created_by' => '12',
            ],
        ];

        $response = SetReferringAffiliateResponse::fromArray(data: $data);

        $this->assertInstanceOf(SetReferringAffiliateResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame(ReferringAffiliateAction::CREATE, $response->action);
        $this->assertSame('789', $response->affiliateId);
        $this->assertSame('affiliate_user', $response->affiliateName);
        $this->assertSame('321', $response->referrerId);
        $this->assertSame('referrer_user', $response->referrerName);
        $this->assertSame(25.5, $response->commission);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->createdAt);
        $this->assertSame('12', $response->createdBy);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'action' => 'update',
                    'affiliate_id' => '456',
                    'referrer_id' => '654',
                    'commission' => 10.0,
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = SetReferringAffiliateResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(SetReferringAffiliateResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame(ReferringAffiliateAction::UPDATE, $response->action);
        $this->assertSame('456', $response->affiliateId);
        $this->assertSame('654', $response->referrerId);
        $this->assertSame(10.0, $response->commission);
    }

    public function test_handles_no_data(): void
    {
        $data = [
            'result' => 'success',
            'data' => [],
        ];

        $response = SetReferringAffiliateResponse::fromArray(data: $data);

        $this->assertInstanceOf(SetReferringAffiliateResponse::class, $response);
        $this->assertNull($response->action);
        $this->assertNull($response->affiliateId);
        $this->assertNull($response->referrerId);
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
                'data' => ['affiliate_id' => '123'],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = SetReferringAffiliateResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
