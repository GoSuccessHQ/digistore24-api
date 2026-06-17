<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Request to list purchases by email address
 *
 * @link https://digistore24.com/api/docs/paths/listPurchasesOfEmail.yaml OpenAPI Specification
 */
final class ListPurchasesOfEmailRequest extends AbstractRequest
{
    /**
     * @param string $email The buyer's email address
     * @param int $limit Maximum number of purchases to show (default: 100, minimum: 1)
     */
    public function __construct(
        public string $email,
        public int $limit = 100,
    ) {
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'limit' => $this->limit,
        ];
    }

    public function getEndpoint(): string
    {
        return '/listPurchasesOfEmail';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }
}
