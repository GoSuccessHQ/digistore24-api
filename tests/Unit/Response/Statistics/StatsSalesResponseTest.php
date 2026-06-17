<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Statistics;

use GoSuccess\Digistore24\Api\DTO\PeriodAmountData;
use GoSuccess\Digistore24\Api\Enum\StatsPeriod;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Statistics\StatsSalesResponse;
use PHPUnit\Framework\TestCase;

final class StatsSalesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'from' => '2024-01-01',
                'to' => '2024-01-31',
                'period' => 'month',
                'amounts' => [
                    'EUR' => [
                        [
                            'from' => '2024-01-01',
                            'to' => '2024-01-31',
                            'total_brutto_amount' => 99.99,
                            'vendor_share_amount' => 80.00,
                        ],
                    ],
                    'USD' => [
                        [
                            'from' => '2024-01-01',
                            'to' => '2024-01-31',
                            'total_brutto_amount' => 149.50,
                        ],
                    ],
                ],
            ],
        ];
        $response = StatsSalesResponse::fromArray($data);

        $this->assertInstanceOf(StatsSalesResponse::class, $response);
        $this->assertSame('2024-01-01', $response->from);
        $this->assertSame('2024-01-31', $response->to);
        $this->assertSame(StatsPeriod::MONTH, $response->period);
        $this->assertArrayHasKey('EUR', $response->amounts);
        $this->assertArrayHasKey('USD', $response->amounts);
        $this->assertCount(1, $response->amounts['EUR']);
        $this->assertInstanceOf(PeriodAmountData::class, $response->amounts['EUR'][0]);
        $this->assertSame(99.99, $response->amounts['EUR'][0]->totalBruttoAmount);
        $this->assertSame(80.00, $response->amounts['EUR'][0]->vendorShareAmount);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'period' => 'day',
                    'amounts' => [
                        'EUR' => [
                            ['total_brutto_amount' => 299.00],
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = StatsSalesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(StatsSalesResponse::class, $response);
        $this->assertSame(StatsPeriod::DAY, $response->period);
        $this->assertCount(1, $response->amounts['EUR']);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = StatsSalesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
