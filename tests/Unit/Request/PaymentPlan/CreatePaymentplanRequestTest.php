<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\PaymentPlan;

use GoSuccess\Digistore24\Api\DTO\PaymentPlanFullData;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\CreatePaymentplanRequest;
use PHPUnit\Framework\TestCase;

final class CreatePaymentplanRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $plan = new PaymentPlanFullData();
        $plan->firstAmount = 49.99;
        $plan->currency = 'USD';

        $request = new CreatePaymentplanRequest(productId: 12345, paymentPlan: $plan);

        $this->assertInstanceOf(CreatePaymentplanRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $plan = new PaymentPlanFullData();
        $plan->firstAmount = 49.99;
        $plan->currency = 'USD';

        $request = new CreatePaymentplanRequest(productId: 12345, paymentPlan: $plan);

        $this->assertSame('/createPaymentplan', $request->getEndpoint());
    }

    public function test_validate_returns_empty_array(): void
    {
        $plan = new PaymentPlanFullData();
        $plan->firstAmount = 49.99;
        $plan->currency = 'USD';

        $request = new CreatePaymentplanRequest(productId: 12345, paymentPlan: $plan);

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
