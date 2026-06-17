<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ServiceProof;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestUpdateData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Update Service Proof Request Request
 *
 * Updates an existing service proof request's status or information.
 */
final class UpdateServiceProofRequestRequest extends AbstractRequest
{
    /**
     * @param string $serviceProofRequestId The unique identifier of the service proof request
     * @param ServiceProofRequestUpdateData $proofData The updated service proof request data
     */
    public function __construct(private string $serviceProofRequestId, private ServiceProofRequestUpdateData $proofData)
    {
    }

    public function getEndpoint(): string
    {
        return '/updateServiceProofRequest';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::PUT;
    }

    public function toArray(): array
    {
        return array_merge(['service_proof_request_id' => $this->serviceProofRequestId], $this->proofData->toArray());
    }
}
