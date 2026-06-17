<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ServiceProof;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Service Proof Requests Response
 *
 * Response object for the ServiceProof API endpoint.
 */
final class ListServiceProofRequestsResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * @var array<string, mixed>
     */
    public array $serviceProofRequests = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $serviceProofRequests = $innerData['service_proof_requests'] ?? [];

        if (! is_array($serviceProofRequests)) {
            $serviceProofRequests = [];
        }

        /** @var array<string, mixed> $validatedRequests */
        $validatedRequests = $serviceProofRequests;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->serviceProofRequests = $validatedRequests;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
