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
 *
 * @link https://digistore24.com/api/docs/paths/updateServiceProofRequest.yaml
 */
final class UpdateServiceProofRequestRequest extends AbstractRequest
{
    /**
     * @param int $serviceProofId The numeric ID of the service proof request to update
     * @param ServiceProofRequestUpdateData $proofData The updated service proof request data
     */
    public function __construct(private int $serviceProofId, private ServiceProofRequestUpdateData $proofData)
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
        return array_merge(['service_proof_id' => $this->serviceProofId], $this->proofData->toArray());
    }
}
