<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\PaymentPlan;

use GoSuccess\Digistore24\Api\DTO\PaymentPlanDiscountTierData;
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

    public function test_to_array_keeps_product_id_flat_and_wraps_data(): void
    {
        $tier = new PaymentPlanDiscountTierData();
        $tier->fromQuantity = 3;
        $tier->unitPrice1st = 9.99;
        $tier->unitPriceOth = 4.99;

        $plan = new PaymentPlanFullData();
        $plan->firstAmount = 49.99;
        $plan->currency = 'USD';
        $plan->numberOfInstallments = 12;
        $plan->isActive = true;
        $plan->isSwitchingAllowed = false;
        $plan->isDiscountEnabled = true;
        $plan->canBuyerTerminateInstallments = 'N_subscription';
        $plan->testInterval = '7_day';
        $plan->startPayplanAt = '2026-01-01';
        $plan->position = 5;
        $plan->isForSale = 'all';
        $plan->discountUnitPrices = [$tier];

        $request = new CreatePaymentplanRequest(productId: 12345, paymentPlan: $plan);
        $array = $request->toArray();

        // product_id stays flat alongside the wrapped data[] object.
        $this->assertSame(12345, $array['product_id']);
        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame(49.99, $data['first_amount']);
        $this->assertSame('USD', $data['currency']);
        $this->assertSame(12, $data['number_of_installments']);
        $this->assertSame('Y', $data['is_active']);
        $this->assertSame('N', $data['is_switching_allowed']);
        $this->assertSame('Y', $data['is_discount_enabled']);
        $this->assertSame('N_subscription', $data['can_buyer_terminate_installments']);
        $this->assertSame('7_day', $data['test_interval']);
        $this->assertSame('2026-01-01', $data['start_payplan_at']);
        $this->assertSame(5, $data['position']);
        $this->assertSame('all', $data['is_for_sale']);
        $this->assertSame(
            [['from_quantity' => 3, 'unit_price_1st' => 9.99, 'unit_price_oth' => 4.99]],
            $data['discount_unit_prices'],
        );
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
