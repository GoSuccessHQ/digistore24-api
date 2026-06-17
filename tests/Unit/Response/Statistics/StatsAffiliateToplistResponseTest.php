<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Statistics;

use GoSuccess\Digistore24\Api\DTO\AffiliateToplistItemData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Statistics\StatsAffiliateToplistResponse;
use PHPUnit\Framework\TestCase;

final class StatsAffiliateToplistResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'top_list' => [
                    [
                        'affiliate_id' => 1,
                        'affiliate_name' => 'Top Affiliate',
                        'currency' => 'EUR',
                        'brutto_amount' => 15000.00,
                        'netto_amount' => 12500.00,
                        'affiliate_amount' => 3000.00,
                        'refund_quota' => 2.5,
                    ],
                    [
                        'affiliate_id' => 2,
                        'affiliate_name' => 'Second Affiliate',
                        'currency' => 'EUR',
                        'brutto_amount' => 12000.00,
                    ],
                ],
            ],
        ];
        $response = StatsAffiliateToplistResponse::fromArray($data);

        $this->assertInstanceOf(StatsAffiliateToplistResponse::class, $response);
        $this->assertCount(2, $response->topList);
        $this->assertInstanceOf(AffiliateToplistItemData::class, $response->topList[0]);
        $this->assertSame(1, $response->topList[0]->affiliateId);
        $this->assertSame('Top Affiliate', $response->topList[0]->affiliateName);
        $this->assertSame(15000.00, $response->topList[0]->bruttoAmount);
        $this->assertSame(2.5, $response->topList[0]->refundQuota);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'top_list' => [
                        [
                            'affiliate_id' => 999,
                            'affiliate_name' => 'Solo',
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = StatsAffiliateToplistResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(StatsAffiliateToplistResponse::class, $response);
        $this->assertCount(1, $response->topList);
        $this->assertSame(999, $response->topList[0]->affiliateId);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = StatsAffiliateToplistResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
