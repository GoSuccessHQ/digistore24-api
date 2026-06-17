<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\OrderForm;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\OrderFormData;

/**
 * Create Order Form Request
 *
 * Creates a new order form with the specified configuration.
 */
final class CreateOrderformRequest extends AbstractRequest
{
    /**
     * @param OrderFormData $orderForm The order form configuration data
     */
    public function __construct(private OrderFormData $orderForm)
    {
    }

    public function getEndpoint(): string
    {
        return '/createOrderform';
    }

    public function toArray(): array
    {
        return $this->orderForm->toArray();
    }
}
