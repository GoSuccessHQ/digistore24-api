<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Purchase;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Purchase\GetPurchaseResponse;
use PHPUnit\Framework\TestCase;

final class GetPurchaseResponseTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function samplePurchase(): array
    {
        return [
            'id' => 'P123456',
            'amount' => 99.99,
            'currency' => 'EUR',
            'other_amounts' => 19.99,
            'other_vat_amounts' => 3.19,
            'number_of_installments' => 0,
            'vat_country' => 'DE',
            'vat_amount' => 15.97,
            'vat_rate' => 19.0,
            'created_at' => '2024-01-15 10:30:00',
            'billing_type' => 'subscription',
            'billing_type_msg' => 'Subscription',
            'billing_status' => 'paying',
            'billing_status_msg' => 'Paying',
            'renew_url' => 'https://www.digistore24.com/renew/P123456',
            'receipt_url' => 'https://www.digistore24.com/receipt/P123456',
            'invoice_url' => 'https://www.digistore24.com/invoice/P123456',
            'has_custom_forms' => 'N',
            'has_etickets' => 'Y',
            'cancel_policy' => '12m_3m',
            'can_cancel_before' => '2025-01-15',
            'upsell_no' => 1,
            'upsell_position' => 'ynyynn',
            'buyer' => [
                'id' => 42,
                'email' => 'buyer@example.com',
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'country' => 'DE',
            ],
            'items' => [
                [
                    'product_name' => 'Premium Course',
                    'product_id' => 789,
                    'quantity' => 1,
                    'no' => 1,
                    'count' => 1,
                    'id' => 5001,
                ],
            ],
            'transaction_list' => [
                [
                    'id' => 9001,
                    'amount' => 99.99,
                    'currency' => 'EUR',
                    'purchase_id' => 'P123456',
                    'pay_method' => 'paypal',
                    'pay_method_msg' => 'PayPal',
                    'created_at' => '2024-01-15 10:31:00',
                    'type' => 'payment',
                    'type_msg' => 'Payment',
                ],
            ],
            'refund_policy' => [
                'purchase_id' => 'P123456',
                'reason_code' => 'consumer',
                'refund_days' => 14,
                'is_reminder_allowed' => 'Y',
                'policy_id' => 7,
                'product_type_id' => 2,
                'delivery_type' => 'digital',
            ],
            'placeholders' => ['servicename' => 'Coaching'],
        ];
    }

    public function test_can_create_from_array(): void
    {
        $response = GetPurchaseResponse::fromArray($this->samplePurchase());

        $this->assertInstanceOf(GetPurchaseResponse::class, $response);
        $this->assertSame('P123456', $response->purchaseId);
        $this->assertSame(99.99, $response->amount);
        $this->assertSame('EUR', $response->currency);
        $this->assertSame(19.99, $response->otherAmounts);
        $this->assertSame(0, $response->numberOfInstallments);
        $this->assertSame('DE', $response->vatCountry);
        $this->assertSame(19.0, $response->vatRate);
        $this->assertSame('subscription', $response->billingType);
        $this->assertSame('paying', $response->billingStatus);
        $this->assertFalse($response->hasCustomForms);
        $this->assertTrue($response->hasEtickets);
        $this->assertSame('12m_3m', $response->cancelPolicy);
        $this->assertSame(1, $response->upsellNo);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->createdAt);

        $this->assertNotNull($response->buyer);
        $this->assertSame('buyer@example.com', $response->buyer->email);
        $this->assertSame('Jane', $response->buyer->firstName);

        $this->assertCount(1, $response->items);
        $this->assertSame('Premium Course', $response->items[0]->productName);
        $this->assertSame(789, $response->items[0]->productId);

        $this->assertCount(1, $response->transactionList);
        $this->assertSame(9001, $response->transactionList[0]->id);
        $this->assertSame('payment', $response->transactionList[0]->type);

        $this->assertNotNull($response->refundPolicy);
        $this->assertSame(14, $response->refundPolicy->refundDays);
        $this->assertTrue($response->refundPolicy->isReminderAllowed);

        $this->assertSame('Coaching', $response->placeholders['servicename']);
        $this->assertArrayHasKey('id', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: $this->samplePurchase(),
            headers: [],
            rawBody: '',
        );

        $response = GetPurchaseResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetPurchaseResponse::class, $response);
        $this->assertSame('P123456', $response->purchaseId);
        $this->assertSame(99.99, $response->amount);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: $this->samplePurchase(),
            headers: [],
            rawBody: 'test',
        );

        $response = GetPurchaseResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
