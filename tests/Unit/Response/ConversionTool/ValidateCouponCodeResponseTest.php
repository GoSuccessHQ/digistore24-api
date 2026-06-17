<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ConversionTool;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ConversionTool\ValidateCouponCodeResponse;
use PHPUnit\Framework\TestCase;

final class ValidateCouponCodeResponseTest extends TestCase
{
    public function test_maps_typed_fields_from_array(): void
    {
        $data = [
            'data' => [
                'status' => 'success',
                'status_msg' => 'Voucher is valid',
                'currency' => 'EUR',
                'coupon_id' => 2477,
                'amount_left' => 10.0,
                'amount_total' => 25.0,
                'is_test_payment' => 'N',
            ],
        ];
        $response = ValidateCouponCodeResponse::fromArray($data);

        $this->assertSame('success', $response->status);
        $this->assertSame('Voucher is valid', $response->statusMsg);
        $this->assertSame('EUR', $response->currency);
        $this->assertSame(2477, $response->couponId);
        $this->assertSame(10.0, $response->amountLeft);
        $this->assertSame(25.0, $response->amountTotal);
        $this->assertFalse($response->isTestPayment);
        $this->assertTrue($response->isValid());
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => ['status' => 'success']],
            headers: [],
            rawBody: '',
        );

        $response = ValidateCouponCodeResponse::fromResponse($httpResponse);

        $this->assertTrue($response->isValid());
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = ValidateCouponCodeResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
