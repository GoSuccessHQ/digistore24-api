<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\ServiceProof;

use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestSearchData;
use GoSuccess\Digistore24\Api\Enum\DeliveryType;
use GoSuccess\Digistore24\Api\Enum\ServiceProofApprovalStatus;
use GoSuccess\Digistore24\Api\Enum\ServiceProofRequestStatus;
use GoSuccess\Digistore24\Api\Request\ServiceProof\ListServiceProofRequestsRequest;
use PHPUnit\Framework\TestCase;

final class ListServiceProofRequestsRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new ListServiceProofRequestsRequest();

        $this->assertInstanceOf(ListServiceProofRequestsRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new ListServiceProofRequestsRequest();

        $this->assertSame('/listServiceProofRequests', $request->getEndpoint());
    }

    public function test_to_array_is_empty_without_search(): void
    {
        $request = new ListServiceProofRequestsRequest();

        $this->assertEmpty($request->toArray());
    }

    public function test_to_array_includes_search_criteria(): void
    {
        $request = new ListServiceProofRequestsRequest(
            search: new ServiceProofRequestSearchData(
                purchaseId: 'P12345',
                productId: 678,
                deliveryType: DeliveryType::SERVICE,
                approvalStatus: ServiceProofApprovalStatus::PENDING,
                requestStatus: ServiceProofRequestStatus::PROOF_PROVIDED,
            ),
        );

        $array = $request->toArray();
        $this->assertIsArray($array['search']);
        /** @var array<string, mixed> $search */
        $search = $array['search'];
        $this->assertSame('P12345', $search['purchase_id']);
        $this->assertSame(678, $search['product_id']);
        $this->assertSame('service', $search['delivery_type']);
        $this->assertSame('pending', $search['approval_status']);
        $this->assertSame('proof_provided', $search['request_status']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new ListServiceProofRequestsRequest();

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
