<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Voucher;

use GoSuccess\Digistore24\Api\DTO\VoucherData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Voucher\GetVoucherResponse;
use PHPUnit\Framework\TestCase;

final class GetVoucherResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'coupon' => [
                    'id' => 12345,
                    'code' => 'SUMMER2024',
                    'product_ids' => 'all',
                    'valid_from' => '2024-01-01 00:00:00',
                    'valid_until' => '2024-12-31 23:59:59',
                    'expires_at' => '2024-12-31 23:59:59',
                    'first_rate' => 20.0,
                    'other_rates' => 15.0,
                    'first_amount' => 10.0,
                    'other_amounts' => 5.0,
                    'currency' => 'EUR',
                    'is_count_limited' => 'Y',
                    'count_left' => 50,
                    'upgrade_policy' => 'valid',
                ],
            ],
        ];

        $response = GetVoucherResponse::fromArray(data: $data);

        $this->assertInstanceOf(GetVoucherResponse::class, $response);
        $this->assertInstanceOf(VoucherData::class, $response->voucher);
        $this->assertSame(12345, $response->voucher->id);
        $this->assertSame('SUMMER2024', $response->voucher->code);
        $this->assertSame('all', $response->voucher->productIds);
        $this->assertSame('2024-01-01 00:00:00', $response->voucher->validFrom);
        $this->assertSame('2024-12-31 23:59:59', $response->voucher->validUntil);
        $this->assertSame('2024-12-31 23:59:59', $response->voucher->expiresAt);
        $this->assertSame(20.0, $response->voucher->firstRate);
        $this->assertSame(15.0, $response->voucher->otherRates);
        $this->assertSame(10.0, $response->voucher->firstAmount);
        $this->assertSame(5.0, $response->voucher->otherAmounts);
        $this->assertSame('EUR', $response->voucher->currency);
        $this->assertTrue($response->voucher->isCountLimited);
        $this->assertSame(50, $response->voucher->countLeft);
        $this->assertSame('valid', $response->voucher->upgradePolicy);

        // The full coupon payload is also exposed as a completeness safety-net.
        $this->assertSame('SUMMER2024', $response->data['code']);
        $this->assertSame(12345, $response->data['id']);
        $this->assertSame('valid', $response->data['upgrade_policy']);
    }

    public function test_can_create_with_minimal_data(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'coupon' => [
                    'code' => 'MINIMAL',
                ],
            ],
        ];

        $response = GetVoucherResponse::fromArray(data: $data);

        $this->assertInstanceOf(GetVoucherResponse::class, $response);
        $this->assertInstanceOf(VoucherData::class, $response->voucher);
        $this->assertSame('MINIMAL', $response->voucher->code);
        $this->assertNull($response->voucher->id);
        $this->assertSame('all', $response->voucher->productIds);
        $this->assertFalse($response->voucher->isCountLimited);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'coupon' => [
                        'id' => 99999,
                        'code' => 'WINTER2024',
                        'first_rate' => 25.0,
                    ],
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = GetVoucherResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(GetVoucherResponse::class, $response);
        $this->assertInstanceOf(VoucherData::class, $response->voucher);
        $this->assertSame(99999, $response->voucher->id);
        $this->assertSame('WINTER2024', $response->voucher->code);
        $this->assertSame(25.0, $response->voucher->firstRate);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'coupon' => [
                        'code' => 'TEST',
                    ],
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = GetVoucherResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }

    public function test_handles_count_limited_flag(): void
    {
        $dataYes = [
            'result' => 'success',
            'data' => [
                'coupon' => [
                    'code' => 'LIMITED',
                    'is_count_limited' => 'Y',
                    'count_left' => 10,
                ],
            ],
        ];

        $responseYes = GetVoucherResponse::fromArray(data: $dataYes);
        $this->assertInstanceOf(VoucherData::class, $responseYes->voucher);
        $this->assertTrue($responseYes->voucher->isCountLimited);
        $this->assertSame(10, $responseYes->voucher->countLeft);

        $dataNo = [
            'result' => 'success',
            'data' => [
                'coupon' => [
                    'code' => 'UNLIMITED',
                    'is_count_limited' => 'N',
                ],
            ],
        ];

        $responseNo = GetVoucherResponse::fromArray(data: $dataNo);
        $this->assertInstanceOf(VoucherData::class, $responseNo->voucher);
        $this->assertFalse($responseNo->voucher->isCountLimited);
    }
}
