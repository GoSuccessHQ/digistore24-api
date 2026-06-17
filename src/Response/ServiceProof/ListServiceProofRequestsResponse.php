<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ServiceProof;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Service Proof Requests Response
 *
 * Response containing a list of service proof requests. Each entry exposes the
 * spec fields (id, purchase_id, product_id, delivery_type, approval_status,
 * request_status, created_at, modified_at) as a typed DTO.
 *
 * @link https://digistore24.com/api/docs/paths/listServiceProofRequests.yaml
 */
final class ListServiceProofRequestsResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * @var array<int, ServiceProofRequestData>
     */
    public array $serviceProofRequests = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $requestsData = $innerData['service_proof_requests'] ?? [];

        $requests = [];
        if (is_array($requestsData)) {
            foreach ($requestsData as $requestItem) {
                if (! is_array($requestItem)) {
                    continue;
                }
                /** @var array<string, mixed> $validRequestItem */
                $validRequestItem = $requestItem;
                $requests[] = ServiceProofRequestData::fromArray($validRequestItem);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->serviceProofRequests = $requests;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
