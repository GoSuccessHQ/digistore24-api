<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\PaymentPlan;

use GoSuccess\Digistore24\Api\DTO\PaymentPlanFullData;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\UpdatePaymentplanRequest;
use PHPUnit\Framework\TestCase;

final class UpdatePaymentplanRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $plan = new PaymentPlanFullData();
        $plan->firstAmount = 29.99;

        $request = new UpdatePaymentplanRequest(
            paymentplanId: 'PP123',
            paymentPlan: $plan,
        );

        $this->assertInstanceOf(UpdatePaymentplanRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $plan = new PaymentPlanFullData();
        $plan->firstAmount = 29.99;

        $request = new UpdatePaymentplanRequest(
            paymentplanId: 'PP123',
            paymentPlan: $plan,
        );

        $this->assertSame('/updatePaymentplan', $request->getEndpoint());
    }

    public function test_to_array_includes_paymentplan_id_and_data(): void
    {
        $plan = new PaymentPlanFullData();
        $plan->firstAmount = 29.99;

        $request = new UpdatePaymentplanRequest(
            paymentplanId: 'PP123',
            paymentPlan: $plan,
        );

        $array = $request->toArray();
        $this->assertSame('PP123', $array['paymentplan_id']);
        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame(29.99, $data['first_amount']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $plan = new PaymentPlanFullData();
        $plan->firstAmount = 29.99;

        $request = new UpdatePaymentplanRequest(
            paymentplanId: 'PP123',
            paymentPlan: $plan,
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
