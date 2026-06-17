<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Statistics;

use GoSuccess\Digistore24\Api\DTO\DailyAmountData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Statistics\StatsDailyAmountsResponse;
use PHPUnit\Framework\TestCase;

final class StatsDailyAmountsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'amount_list' => [
                    [
                        'day' => '2024-01-15',
                        'currency' => 'EUR',
                        'total_brutto_amount' => 1250.50,
                        'vendor_netto_amount' => 980.00,
                    ],
                    [
                        'day' => '2024-01-16',
                        'currency' => 'EUR',
                        'total_brutto_amount' => 980.00,
                    ],
                ],
            ],
        ];
        $response = StatsDailyAmountsResponse::fromArray($data);

        $this->assertInstanceOf(StatsDailyAmountsResponse::class, $response);
        $this->assertCount(2, $response->amountList);
        $this->assertInstanceOf(DailyAmountData::class, $response->amountList[0]);
        $this->assertSame('2024-01-15', $response->amountList[0]->day);
        $this->assertSame('EUR', $response->amountList[0]->currency);
        $this->assertSame(1250.50, $response->amountList[0]->totalBruttoAmount);
        $this->assertSame(980.00, $response->amountList[0]->vendorNettoAmount);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'amount_list' => [
                        [
                            'day' => '2024-01-20',
                            'total_brutto_amount' => 500.00,
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = StatsDailyAmountsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(StatsDailyAmountsResponse::class, $response);
        $this->assertCount(1, $response->amountList);
        $this->assertSame('2024-01-20', $response->amountList[0]->day);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = StatsDailyAmountsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
