<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Affiliate;

use GoSuccess\Digistore24\Api\Enum\AffiliationStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Affiliate\ValidateAffiliateResponse;
use PHPUnit\Framework\TestCase;

final class ValidateAffiliateResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'have_affiliation' => 'Y',
                'affiliation_status' => 'approved',
                'invalid_affiliate_name' => false,
                'affiliation_status_msg' => 'Affiliation approved',
                'invite_url' => 'https://www.digistore24.com/invite/123',
                'valid_product_ids' => '11,22,33',
                'invalid_product_ids' => '',
            ],
        ];

        $response = ValidateAffiliateResponse::fromArray(data: $data);

        $this->assertInstanceOf(ValidateAffiliateResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertTrue($response->haveAffiliation);
        $this->assertSame(AffiliationStatus::APPROVED, $response->affiliationStatus);
        $this->assertFalse($response->invalidAffiliateName);
        $this->assertSame('Affiliation approved', $response->affiliationStatusMsg);
        $this->assertSame('https://www.digistore24.com/invite/123', $response->inviteUrl);
        $this->assertSame('11,22,33', $response->validProductIds);
        $this->assertSame('', $response->invalidProductIds);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'have_affiliation' => 'N',
                    'affiliation_status' => 'wait_for_approval',
                    'invalid_affiliate_name' => false,
                    'valid_product_ids' => '11',
                    'invalid_product_ids' => '22',
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = ValidateAffiliateResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(ValidateAffiliateResponse::class, $response);
        $this->assertFalse($response->haveAffiliation);
        $this->assertSame(AffiliationStatus::WAIT_FOR_APPROVAL, $response->affiliationStatus);
        $this->assertSame('11', $response->validProductIds);
        $this->assertSame('22', $response->invalidProductIds);
    }

    public function test_handles_invalid_affiliate(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'have_affiliation' => 'N',
                'affiliation_status' => 'no_affiliation',
                'invalid_affiliate_name' => true,
            ],
        ];

        $response = ValidateAffiliateResponse::fromArray(data: $data);

        $this->assertInstanceOf(ValidateAffiliateResponse::class, $response);
        $this->assertFalse($response->haveAffiliation);
        $this->assertSame(AffiliationStatus::NO_AFFILIATION, $response->affiliationStatus);
        $this->assertTrue($response->invalidAffiliateName);
        $this->assertNull($response->inviteUrl);
        $this->assertNull($response->validProductIds);
        $this->assertNull($response->invalidProductIds);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => ['have_affiliation' => 'Y'],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = ValidateAffiliateResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
