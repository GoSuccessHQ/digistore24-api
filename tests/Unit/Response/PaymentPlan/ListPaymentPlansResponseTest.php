<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\PaymentPlan;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\PaymentPlan\ListPaymentPlansResponse;
use PHPUnit\Framework\TestCase;

final class ListPaymentPlansResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'payment_plans' => [
                    [
                        'id' => 1,
                        'product_id' => 100,
                        'name' => 'Monthly Plan',
                        'created_at' => '2024-01-01 10:00:00',
                        'modified_at' => '2024-02-01 10:00:00',
                    ],
                    [
                        'id' => 2,
                        'product_id' => 100,
                        'name' => 'Yearly Plan',
                    ],
                ],
            ],
        ];
        $response = ListPaymentPlansResponse::fromArray($data);

        $this->assertInstanceOf(ListPaymentPlansResponse::class, $response);
        $this->assertCount(2, $response->paymentPlans);
        $this->assertSame(1, $response->paymentPlans[0]->id);
        $this->assertSame(100, $response->paymentPlans[0]->productId);
        $this->assertSame('Monthly Plan', $response->paymentPlans[0]->name);
        $this->assertSame('2024-01-01 10:00:00', $response->paymentPlans[0]->createdAt?->format('Y-m-d H:i:s'));
        $this->assertSame('2024-02-01 10:00:00', $response->paymentPlans[0]->modifiedAt?->format('Y-m-d H:i:s'));
    }

    public function test_can_create_from_bare_array_payload(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    [
                        'id' => 3,
                        'product_id' => 200,
                        'name' => 'Lifetime Plan',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListPaymentPlansResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListPaymentPlansResponse::class, $response);
        $this->assertCount(1, $response->paymentPlans);
        $this->assertSame(3, $response->paymentPlans[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListPaymentPlansResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
