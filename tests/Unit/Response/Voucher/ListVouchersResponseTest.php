<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Voucher;

use GoSuccess\Digistore24\Api\DTO\VoucherData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Voucher\ListVouchersResponse;
use PHPUnit\Framework\TestCase;

final class ListVouchersResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'coupons' => [
                    [
                        'id' => 2477,
                        'code' => 'SUMMER2024',
                        'product_ids' => 'all',
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
                        'is_discarding_early_bird' => 'N',
                    ],
                    [
                        'id' => 2478,
                        'code' => 'WINTER2024',
                        'product_ids' => '123,456',
                        'first_rate' => 0.0,
                        'other_rates' => 0.0,
                        'first_amount' => 25.0,
                        'other_amounts' => 0.0,
                        'currency' => 'USD',
                        'is_count_limited' => 'N',
                        'upgrade_policy' => 'other_only',
                        'is_discarding_early_bird' => 'Y',
                    ],
                ],
                'are_returned_data_public' => 'Y',
            ],
        ];

        $response = ListVouchersResponse::fromArray(data: $data);

        $this->assertInstanceOf(ListVouchersResponse::class, $response);
        $this->assertCount(2, $response->coupons);
        $this->assertTrue($response->areReturnedDataPublic);

        // Check first voucher
        $this->assertInstanceOf(VoucherData::class, $response->coupons[0]);
        $this->assertSame(2477, $response->coupons[0]->id);
        $this->assertSame('SUMMER2024', $response->coupons[0]->code);
        $this->assertSame('all', $response->coupons[0]->productIds);
        $this->assertSame(20.0, $response->coupons[0]->firstRate);
        $this->assertTrue($response->coupons[0]->isCountLimited);
        $this->assertSame(50, $response->coupons[0]->countLeft);
        $this->assertFalse($response->coupons[0]->isDiscardingEarlyBird);

        // Check second voucher
        $this->assertInstanceOf(VoucherData::class, $response->coupons[1]);
        $this->assertSame(2478, $response->coupons[1]->id);
        $this->assertSame('WINTER2024', $response->coupons[1]->code);
        $this->assertSame('123,456', $response->coupons[1]->productIds);
        $this->assertSame(25.0, $response->coupons[1]->firstAmount);
        $this->assertFalse($response->coupons[1]->isCountLimited);
        $this->assertTrue($response->coupons[1]->isDiscardingEarlyBird);
    }

    public function test_can_create_with_empty_list(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'coupons' => [],
                'are_returned_data_public' => 'N',
            ],
        ];

        $response = ListVouchersResponse::fromArray(data: $data);

        $this->assertInstanceOf(ListVouchersResponse::class, $response);
        $this->assertCount(0, $response->coupons);
        $this->assertFalse($response->areReturnedDataPublic);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'coupons' => [
                        [
                            'id' => 9999,
                            'code' => 'SPRING2024',
                            'first_rate' => 15.0,
                        ],
                    ],
                    'are_returned_data_public' => 'Y',
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = ListVouchersResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(ListVouchersResponse::class, $response);
        $this->assertCount(1, $response->coupons);
        $this->assertSame(9999, $response->coupons[0]->id);
        $this->assertSame('SPRING2024', $response->coupons[0]->code);
        $this->assertTrue($response->areReturnedDataPublic);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'coupons' => [],
                    'are_returned_data_public' => 'N',
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = ListVouchersResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
