<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\OrderForm;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * Get Order Form Request
 *
 * Retrieves detailed information about a specific order form.
 */
final class GetOrderformRequest extends AbstractRequest
{
    /**
     * @param string $orderformId The unique identifier of the order form
     */
    public function __construct(private string $orderformId)
    {
    }

    public function getEndpoint(): string
    {
        return '/getOrderform';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        return ['orderform_id' => $this->orderformId];
    }
}
