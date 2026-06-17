<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Marketplace;

use GoSuccess\Digistore24\Api\DTO\MarketplaceEntryData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Marketplace\ListMarketplaceEntriesResponse;
use PHPUnit\Framework\TestCase;

final class ListMarketplaceEntriesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'entries' => [
                    [
                        'id' => 123,
                        'headline' => 'Amazing Product',
                        'price' => 99.99,
                        'stats_stars' => 4.5,
                    ],
                    [
                        'id' => 456,
                        'headline' => 'Great Service',
                        'approval_status' => 'pending',
                    ],
                ],
            ],
        ];
        $response = ListMarketplaceEntriesResponse::fromArray($data);

        $this->assertInstanceOf(ListMarketplaceEntriesResponse::class, $response);
        $this->assertCount(2, $response->entries);
        $first = $response->entries[0];
        $this->assertInstanceOf(MarketplaceEntryData::class, $first);
        $this->assertSame(123, $first->id);
        $this->assertSame('Amazing Product', $first->headline);
        $this->assertSame(99.99, $first->price);
        $this->assertSame(4.5, $first->statsStars);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'entries' => [
                        [
                            'id' => 789,
                            'headline' => 'New Product',
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListMarketplaceEntriesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListMarketplaceEntriesResponse::class, $response);
        $this->assertCount(1, $response->entries);
        $this->assertSame(789, $response->entries[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListMarketplaceEntriesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
