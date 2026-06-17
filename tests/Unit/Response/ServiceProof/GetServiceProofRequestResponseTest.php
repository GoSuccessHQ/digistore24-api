<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ServiceProof;

use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ServiceProof\GetServiceProofRequestResponse;
use PHPUnit\Framework\TestCase;

final class GetServiceProofRequestResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'service_proof_request' => [
                    'id' => 123456,
                    'purchase_id' => 'P789012',
                    'status' => 'pending',
                    'created_at' => '2024-01-15 10:00:00',
                    'due_date' => '2024-01-22',
                    'notes' => 'Provide proof of service',
                ],
            ],
        ];
        $response = GetServiceProofRequestResponse::fromArray($data);

        $this->assertInstanceOf(GetServiceProofRequestResponse::class, $response);
        $this->assertSame(123456, $response->id);
        $this->assertSame('P789012', $response->purchaseId);
        $this->assertSame('pending', $response->status);
        $this->assertSame('Provide proof of service', $response->notes);
        $this->assertInstanceOf(ServiceProofRequestData::class, $response->serviceProofRequest);
        $this->assertSame(123456, $response->serviceProofRequest->id);
        $this->assertArrayHasKey('status', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'service_proof_request' => [
                        'id' => 999,
                        'status' => 'completed',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetServiceProofRequestResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetServiceProofRequestResponse::class, $response);
        $this->assertSame(999, $response->id);
        $this->assertSame('completed', $response->status);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'service_proof_request' => [],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = GetServiceProofRequestResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertNull($response->serviceProofRequest);
    }
}
