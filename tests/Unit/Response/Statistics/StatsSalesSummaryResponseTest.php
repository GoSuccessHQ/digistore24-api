<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Statistics;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Statistics\StatsSalesSummaryResponse;
use PHPUnit\Framework\TestCase;

final class StatsSalesSummaryResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'for' => [
                    'all' => [
                        'from' => '2010-01-01',
                        'to' => '2024-01-31',
                        'amounts' => [
                            'EUR' => [
                                'total_brutto_amount' => 45000.50,
                                'total_netto_amount' => 38000.00,
                            ],
                        ],
                    ],
                    'month' => [
                        'from' => '2024-01-01',
                        'to' => '2024-01-31',
                        'amounts' => [
                            'EUR' => [
                                'total_brutto_amount' => 5000.00,
                            ],
                        ],
                    ],
                ],
                'call_duration_ms' => [
                    'amount_for_all' => 12.5,
                    'total_call' => 30.0,
                ],
            ],
        ];
        $response = StatsSalesSummaryResponse::fromArray($data);

        $this->assertInstanceOf(StatsSalesSummaryResponse::class, $response);
        $this->assertArrayHasKey('all', $response->for);
        $this->assertArrayHasKey('month', $response->for);
        $this->assertSame(30.0, $response->callDurationMs['total_call']);

        $all = $response->for['all'];
        $this->assertIsArray($all);
        $this->assertSame('2010-01-01', $all['from']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'for' => [
                        'day' => [
                            'from' => '2024-01-31',
                            'to' => '2024-01-31',
                            'amounts' => ['USD' => ['total_brutto_amount' => 100.00]],
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = StatsSalesSummaryResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(StatsSalesSummaryResponse::class, $response);
        $this->assertArrayHasKey('day', $response->for);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = StatsSalesSummaryResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
