<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\PaymentPlan;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\PaymentPlan\CreatePaymentplanResponse;
use PHPUnit\Framework\TestCase;

final class CreatePaymentplanResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'paymentplan_id' => 123456,
                'rendered_texts' => [
                    'headline' => 'Pay in installments',
                    'description' => '12 monthly payments',
                    'footnote' => 'Terms apply',
                ],
                'plan' => [
                    'id' => 123456,
                    'first_amount' => 49.99,
                ],
            ],
        ];
        $response = CreatePaymentplanResponse::fromArray($data);

        $this->assertInstanceOf(CreatePaymentplanResponse::class, $response);
        $this->assertSame(123456, $response->paymentplanId);
        $this->assertSame('123456', $response->getPaymentplanId());
        $this->assertNotNull($response->renderedTexts);
        $this->assertSame('Pay in installments', $response->renderedTexts->headline);
        $this->assertSame('12 monthly payments', $response->renderedTexts->description);
        $this->assertSame('Terms apply', $response->renderedTexts->footnote);
        $this->assertSame(49.99, $response->plan['first_amount']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'paymentplan_id' => 789012,
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = CreatePaymentplanResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(CreatePaymentplanResponse::class, $response);
        $this->assertSame(789012, $response->paymentplanId);
        $this->assertSame('789012', $response->getPaymentplanId());
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = CreatePaymentplanResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
