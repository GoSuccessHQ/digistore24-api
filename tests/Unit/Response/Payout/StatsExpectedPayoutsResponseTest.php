<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Payout;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Payout\StatsExpectedPayoutsResponse;
use PHPUnit\Framework\TestCase;

final class StatsExpectedPayoutsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'total_earnings' => ['EUR' => 5000.00, 'USD' => 1200.00],
                'paidout_amount' => ['EUR' => 3000.00],
                'pending_amount' => ['EUR' => 2000.00],
                'future_amounts' => [
                    '2024-02-01' => [
                        'amount' => 2000.00,
                        'can_payout' => 'Y',
                        'treshold' => 50.0,
                        'note' => '',
                    ],
                ],
                'by_reseller' => [
                    ['reseller_id' => 1, 'reseller_name' => 'Digistore24'],
                ],
                'note' => ['message' => 'All good', 'reasons' => []],
                'call_duration_ms' => ['total' => 12.5],
            ],
        ];
        $response = StatsExpectedPayoutsResponse::fromArray($data);

        $this->assertInstanceOf(StatsExpectedPayoutsResponse::class, $response);
        $this->assertSame(5000.00, $response->totalEarnings['EUR']);
        $this->assertSame(3000.00, $response->paidoutAmount['EUR']);
        $this->assertSame(2000.00, $response->pendingAmount['EUR']);
        $this->assertArrayHasKey('2024-02-01', $response->futureAmounts);
        $this->assertCount(1, $response->byReseller);
        $this->assertSame('All good', $response->note['message']);
        $this->assertSame(12.5, $response->callDurationMs['total']);
        $this->assertArrayHasKey('total_earnings', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'total_earnings' => ['EUR' => 7500.00],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = StatsExpectedPayoutsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(StatsExpectedPayoutsResponse::class, $response);
        $this->assertSame(7500.00, $response->totalEarnings['EUR']);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = StatsExpectedPayoutsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
