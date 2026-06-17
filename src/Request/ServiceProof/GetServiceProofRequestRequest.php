<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ServiceProof;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Service Proof Request Request
 *
 * Retrieves detailed information about a specific service proof request.
 */
final class GetServiceProofRequestRequest extends AbstractRequest
{
    /**
     * @param string $serviceProofRequestId The unique identifier of the service proof request
     */
    public function __construct(private string $serviceProofRequestId)
    {
    }

    public function getEndpoint(): string
    {
        return '/getServiceProofRequest';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['service_proof_request_id' => $this->serviceProofRequestId];
    }
}
