<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Shipping;

use GoSuccess\Digistore24\Api\Request\Shipping\DeleteShippingCostPolicyRequest;
use PHPUnit\Framework\TestCase;

final class DeleteShippingCostPolicyRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new DeleteShippingCostPolicyRequest(shippingCostPolicyId: 'SCP123');

        $this->assertInstanceOf(DeleteShippingCostPolicyRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new DeleteShippingCostPolicyRequest(shippingCostPolicyId: 'SCP123');

        $this->assertSame('/deleteShippingCostPolicy', $request->getEndpoint());
    }

    public function test_to_array_includes_policy_id(): void
    {
        $request = new DeleteShippingCostPolicyRequest(shippingCostPolicyId: 'SCP123');

        $array = $request->toArray();
        $this->assertSame('SCP123', $array['policy_id']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new DeleteShippingCostPolicyRequest(shippingCostPolicyId: 'SCP123');

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
