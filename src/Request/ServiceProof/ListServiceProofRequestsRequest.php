<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\ServiceProof;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List Service Proof Requests Request
 *
 * Retrieves a paginated list of service proof requests.
 */
final class ListServiceProofRequestsRequest extends AbstractRequest
{
    /**
     * @param int|null $limit Maximum number of results to return
     * @param int|null $offset Number of results to skip for pagination
     */
    public function __construct(private ?int $limit = null, private ?int $offset = null)
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
        if ($this->limit !== null) {
            $params['limit'] = $this->limit;
        }
        if ($this->offset !== null) {
            $params['offset'] = $this->offset;
        }

        return $params;
    }
}
