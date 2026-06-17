<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Shipping;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Shipping\CreateShippingCostPolicyResponse;
use PHPUnit\Framework\TestCase;

final class CreateShippingCostPolicyResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'policy_id' => 123,
            ],
        ];
        $response = CreateShippingCostPolicyResponse::fromArray($data);

        $this->assertInstanceOf(CreateShippingCostPolicyResponse::class, $response);
        $this->assertSame(123, $response->policyId);
        $this->assertSame(123, $response->data['policy_id']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'policy_id' => 999,
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = CreateShippingCostPolicyResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(CreateShippingCostPolicyResponse::class, $response);
        $this->assertSame(999, $response->policyId);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['result' => 'success', 'data' => []],
            headers: [],
            rawBody: 'test',
        );

        $response = CreateShippingCostPolicyResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
