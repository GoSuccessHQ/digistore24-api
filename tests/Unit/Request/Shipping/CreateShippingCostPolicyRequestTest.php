<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Shipping;

use GoSuccess\Digistore24\Api\DTO\ShippingCostPolicyData;
use GoSuccess\Digistore24\Api\Request\Shipping\CreateShippingCostPolicyRequest;
use PHPUnit\Framework\TestCase;

final class CreateShippingCostPolicyRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $policy = new ShippingCostPolicyData();
        $policy->name = 'Standard Shipping';

        $request = new CreateShippingCostPolicyRequest(policy: $policy);

        $this->assertInstanceOf(CreateShippingCostPolicyRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $policy = new ShippingCostPolicyData();
        $policy->name = 'Standard Shipping';

        $request = new CreateShippingCostPolicyRequest(policy: $policy);

        $this->assertSame('/createShippingCostPolicy', $request->getEndpoint());
    }

    public function test_to_array_includes_data(): void
    {
        $policy = new ShippingCostPolicyData();
        $policy->name = 'Standard Shipping';
        $policy->position = 50;

        $request = new CreateShippingCostPolicyRequest(policy: $policy);

        $array = $request->toArray();
        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame('Standard Shipping', $data['name']);
        $this->assertSame(50, $data['position']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $policy = new ShippingCostPolicyData();
        $policy->name = 'Standard Shipping';

        $request = new CreateShippingCostPolicyRequest(policy: $policy);

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
