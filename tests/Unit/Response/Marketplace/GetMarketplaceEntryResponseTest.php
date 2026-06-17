<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Marketplace;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Marketplace\GetMarketplaceEntryResponse;
use PHPUnit\Framework\TestCase;

final class GetMarketplaceEntryResponseTest extends TestCase
{
    public function test_maps_typed_fields_from_array(): void
    {
        $data = [
            'data' => [
                'id' => 42,
                'main_product_id' => 100,
                'all_product_ids' => [100, 101, 102],
                'approval_status' => 'approved',
                'price' => 99.99,
                'currency' => 'EUR',
                'headline' => 'Premium Course',
                'stats_is_valid' => 'Y',
                'stats_stars' => 4.5,
                'stats_count_orders' => 1234,
            ],
        ];
        $response = GetMarketplaceEntryResponse::fromArray($data);

        $this->assertSame(42, $response->id);
        $this->assertSame(100, $response->mainProductId);
        $this->assertSame([100, 101, 102], $response->allProductIds);
        $this->assertSame('approved', $response->approvalStatus);
        $this->assertSame(99.99, $response->price);
        $this->assertSame('EUR', $response->currency);
        $this->assertSame('Premium Course', $response->headline);
        $this->assertTrue($response->statsIsValid);
        $this->assertSame(4.5, $response->statsStars);
        $this->assertSame(1234, $response->statsCountOrders);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => ['id' => 7, 'headline' => 'Starter Package', 'price' => 49.99]],
            headers: [],
            rawBody: '',
        );

        $response = GetMarketplaceEntryResponse::fromResponse($httpResponse);

        $this->assertSame(7, $response->id);
        $this->assertSame('Starter Package', $response->headline);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = GetMarketplaceEntryResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
