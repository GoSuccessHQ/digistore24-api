<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Product;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Product\GetProductResponse;
use GoSuccess\Digistore24\Api\Response\Product\ProductListItem;
use PHPUnit\Framework\TestCase;

final class GetProductResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'product' => [
                'id' => '123',
                'name' => 'Premium Course',
                'name_intern' => 'premium-course',
                'currency' => 'EUR',
                'language' => 'en',
                'product_type_id' => 4,
                'product_group_id' => 7,
                'is_active' => 'Y',
                'affiliate_commission' => '25.00',
                'salespage_url' => 'https://example.com/sales',
                'approval_status' => 'approved',
                'buyer_type' => 'consumer',
            ],
        ];
        $response = GetProductResponse::fromArray($data);

        $this->assertInstanceOf(GetProductResponse::class, $response);
        $this->assertSame('123', $response->id);
        $this->assertSame('Premium Course', $response->name);
        $this->assertSame('premium-course', $response->nameIntern);
        $this->assertSame('EUR', $response->currency);
        $this->assertSame(4, $response->productTypeId);
        $this->assertTrue($response->isActive);
        $this->assertSame('25.00', $response->affiliateCommission);
        $this->assertSame('consumer', $response->buyerType);
        $this->assertInstanceOf(ProductListItem::class, $response->product);
        $this->assertSame('123', $response->product->id);
        $this->assertArrayHasKey('salespage_url', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'product' => [
                        'id' => '456',
                        'name' => 'Basic Package',
                        'currency' => 'USD',
                        'is_active' => 'N',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetProductResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetProductResponse::class, $response);
        $this->assertSame('456', $response->id);
        $this->assertSame('Basic Package', $response->name);
        $this->assertSame('USD', $response->currency);
        $this->assertFalse($response->isActive);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = GetProductResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
