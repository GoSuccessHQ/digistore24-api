<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Payout;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Payout\ListPayoutsResponse;
use PHPUnit\Framework\TestCase;

final class ListPayoutsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'payout_list' => [
                    [
                        'id' => 123,
                        'credit_note_url' => 'https://example.com/cn/123.pdf',
                        'commission_list_url' => 'https://example.com/cl/123.csv',
                        'reseller_name' => 'Digistore24',
                        'reseller_id' => 1,
                        'created_at' => '2024-01-15 12:00:00',
                        'processed_at' => '2024-01-16 12:00:00',
                        'vat_rate' => 19.0,
                        'vat_regulation' => 'eu',
                        'currency' => 'EUR',
                        'payout_method' => 'paypal',
                        'vendor_gross_amount' => 1500.00,
                        'vendor_net_amount' => 1260.50,
                        'vendor_vat_amount' => 239.50,
                        'affiliate_gross_amount' => 0.0,
                        'affiliate_net_amount' => 0.0,
                        'affiliate_vat_amount' => 0.0,
                        'fee_amount' => 10.0,
                        'fee_vat_amount' => 1.9,
                    ],
                    [
                        'id' => 456,
                        'currency' => 'USD',
                        'vendor_gross_amount' => 2500.00,
                    ],
                ],
            ],
        ];
        $response = ListPayoutsResponse::fromArray($data);

        $this->assertInstanceOf(ListPayoutsResponse::class, $response);
        $this->assertCount(2, $response->payoutList);

        $first = $response->payoutList[0];
        $this->assertSame(123, $first->id);
        $this->assertSame('https://example.com/cn/123.pdf', $first->creditNoteUrl);
        $this->assertSame('Digistore24', $first->resellerName);
        $this->assertSame(1, $first->resellerId);
        $this->assertSame(19.0, $first->vatRate);
        $this->assertSame('EUR', $first->currency);
        $this->assertSame('paypal', $first->payoutMethod);
        $this->assertSame(1500.00, $first->vendorGrossAmount);
        $this->assertSame(1260.50, $first->vendorNetAmount);
        $this->assertSame(10.0, $first->feeAmount);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'payout_list' => [
                        [
                            'id' => 789,
                            'currency' => 'EUR',
                            'vendor_gross_amount' => 3000.00,
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListPayoutsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListPayoutsResponse::class, $response);
        $this->assertCount(1, $response->payoutList);
        $this->assertSame(789, $response->payoutList[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListPayoutsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
