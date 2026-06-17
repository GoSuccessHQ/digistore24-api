<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\ServiceProof;

use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestUpdateData;
use GoSuccess\Digistore24\Api\Request\ServiceProof\UpdateServiceProofRequestRequest;
use PHPUnit\Framework\TestCase;

final class UpdateServiceProofRequestRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $proof = new ServiceProofRequestUpdateData();
        $proof->requestStatus = 'proof_provided';

        $request = new UpdateServiceProofRequestRequest(
            serviceProofRequestId: 'SPR123',
            proofData: $proof,
        );

        $this->assertInstanceOf(UpdateServiceProofRequestRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $proof = new ServiceProofRequestUpdateData();
        $proof->requestStatus = 'proof_provided';

        $request = new UpdateServiceProofRequestRequest(
            serviceProofRequestId: 'SPR123',
            proofData: $proof,
        );

        $this->assertSame('/updateServiceProofRequest', $request->getEndpoint());
    }

    public function test_to_array_includes_id_and_data(): void
    {
        $proof = new ServiceProofRequestUpdateData();
        $proof->requestStatus = 'proof_provided';
        $proof->message = 'Looks good';

        $request = new UpdateServiceProofRequestRequest(
            serviceProofRequestId: 'SPR123',
            proofData: $proof,
        );

        $array = $request->toArray();

        $this->assertSame('SPR123', $array['service_proof_id']);
        $data = $array['data'] ?? null;
        $this->assertIsArray($data);
        /** @var array<string, mixed> $validatedData */
        $validatedData = $data;
        $this->assertSame('proof_provided', $validatedData['request_status']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $proof = ServiceProofRequestUpdateData::fromArray([
            'data' => ['request_status' => 'proof_provided'],
        ]);

        $request = new UpdateServiceProofRequestRequest(
            serviceProofRequestId: 'SPR123',
            proofData: $proof,
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
