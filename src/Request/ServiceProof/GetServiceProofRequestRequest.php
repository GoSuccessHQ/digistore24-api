<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ServiceProof;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Service Proof Request Request
 *
 * Retrieves detailed information about a specific service proof request.
 *
 * @link https://digistore24.com/api/docs/paths/getServiceProofRequest.yaml
 */
final class GetServiceProofRequestRequest extends AbstractRequest
{
    /**
     * @param int $serviceProofId Numeric ID of the service proof request
     */
    public function __construct(private int $serviceProofId)
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
        return ['service_proof_id' => $this->serviceProofId];
    }
}
