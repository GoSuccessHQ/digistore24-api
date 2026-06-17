<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ServiceProof;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get Service Proof Request Response
 *
 * Response object for the ServiceProof API endpoint.
 */
final class GetServiceProofRequestResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * @var array<string, mixed>
     */
    public array $serviceProofRequest = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $serviceProofRequest = $innerData['service_proof_request'] ?? [];

        if (! is_array($serviceProofRequest)) {
            $serviceProofRequest = [];
        }

        /** @var array<string, mixed> $validatedRequest */
        $validatedRequest = $serviceProofRequest;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->serviceProofRequest = $validatedRequest;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
