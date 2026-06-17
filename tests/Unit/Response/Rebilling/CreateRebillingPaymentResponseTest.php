<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Rebilling;

use GoSuccess\Digistore24\Api\Enum\BillingPaymentStatus;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Rebilling\CreateRebillingPaymentResponse;
use PHPUnit\Framework\TestCase;

final class CreateRebillingPaymentResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'purchase_id' => 'P123456',
                'payment_status' => 'completed',
                'payment_message' => '',
                'billing_status' => 'paying',
                'payment_data_update_url' => 'https://www.digistore24.com/update/P123456',
            ],
        ];
        $response = CreateRebillingPaymentResponse::fromArray($data);

        $this->assertInstanceOf(CreateRebillingPaymentResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame('P123456', $response->purchaseId);
        $this->assertSame(BillingPaymentStatus::COMPLETED, $response->paymentStatus);
        $this->assertSame('paying', $response->billingStatus);
        $this->assertSame('https://www.digistore24.com/update/P123456', $response->paymentDataUpdateUrl);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'purchase_id' => 'P999',
                    'payment_status' => 'refused',
                    'payment_message' => 'Card declined',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = CreateRebillingPaymentResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(CreateRebillingPaymentResponse::class, $response);
        $this->assertSame(BillingPaymentStatus::REFUSED, $response->paymentStatus);
        $this->assertSame('Card declined', $response->paymentMessage);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = CreateRebillingPaymentResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
