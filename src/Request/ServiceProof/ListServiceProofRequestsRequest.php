<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ServiceProof;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestSearchData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Service Proof Requests Request
 *
 * Retrieves a list of service proof requests, optionally filtered by a search
 * object (purchase_id, product_id, delivery_type, approval_status, request_status).
 *
 * @link https://digistore24.com/api/docs/paths/listServiceProofRequests.yaml
 */
final class ListServiceProofRequestsRequest extends AbstractRequest
{
    /**
     * @param ServiceProofRequestSearchData|null $search Optional search criteria
     */
    public function __construct(private ?ServiceProofRequestSearchData $search = null)
    {
    }

    public function getEndpoint(): string
    {
        return '/listServiceProofRequests';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $params = [];

        if ($this->search !== null) {
            $searchParams = $this->search->toArray();
            if ($searchParams !== []) {
                $params['search'] = $searchParams;
            }
        }

        return $params;
    }
}
