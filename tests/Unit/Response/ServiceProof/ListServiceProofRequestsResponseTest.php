<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ServiceProof;

use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ServiceProof\ListServiceProofRequestsResponse;
use PHPUnit\Framework\TestCase;

final class ListServiceProofRequestsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'service_proof_requests' => [
                    [
                        'id' => 1,
                        'purchase_id' => 'P001',
                        'product_id' => 100,
                        'delivery_type' => 'service',
                        'approval_status' => 'approved',
                        'request_status' => 'pending',
                        'created_at' => '2024-01-15 10:00:00',
                        'modified_at' => '2024-01-16 12:00:00',
                    ],
                    [
                        'id' => 2,
                        'purchase_id' => 'P002',
                        'request_status' => 'proof_provided',
                    ],
                ],
            ],
        ];
        $response = ListServiceProofRequestsResponse::fromArray($data);

        $this->assertInstanceOf(ListServiceProofRequestsResponse::class, $response);
        $this->assertCount(2, $response->serviceProofRequests);
        $first = $response->serviceProofRequests[0];
        $this->assertInstanceOf(ServiceProofRequestData::class, $first);
        $this->assertSame(1, $first->id);
        $this->assertSame('P001', $first->purchaseId);
        $this->assertSame(100, $first->productId);
        $this->assertSame('service', $first->deliveryType);
        $this->assertSame('approved', $first->approvalStatus);
        $this->assertSame('pending', $first->requestStatus);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'service_proof_requests' => [
                        ['id' => 999, 'request_status' => 'exec_refund'],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListServiceProofRequestsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListServiceProofRequestsResponse::class, $response);
        $this->assertCount(1, $response->serviceProofRequests);
        $this->assertSame(999, $response->serviceProofRequests[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'service_proof_requests' => [],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = ListServiceProofRequestsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
