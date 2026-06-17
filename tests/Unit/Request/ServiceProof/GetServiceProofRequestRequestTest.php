<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\ServiceProof;

use GoSuccess\Digistore24\Api\Request\ServiceProof\GetServiceProofRequestRequest;
use PHPUnit\Framework\TestCase;

final class GetServiceProofRequestRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new GetServiceProofRequestRequest(serviceProofId: 12345);

        $this->assertInstanceOf(GetServiceProofRequestRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new GetServiceProofRequestRequest(serviceProofId: 12345);

        $this->assertSame('/getServiceProofRequest', $request->getEndpoint());
    }

    public function test_to_array_includes_service_proof_id(): void
    {
        $request = new GetServiceProofRequestRequest(serviceProofId: 12345);

        $array = $request->toArray();
        $this->assertSame(12345, $array['service_proof_id']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new GetServiceProofRequestRequest(serviceProofId: 12345);

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
