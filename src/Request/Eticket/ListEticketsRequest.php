<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;

/**
 * List E-Tickets Request
 *
 * Lists all e-tickets, optionally filtered by product, location, or date range.
 */
final class ListEticketsRequest extends AbstractRequest
{
    public function __construct(
        public readonly ?string $productId = null,
        public readonly ?string $locationId = null,
        public readonly ?\DateTimeInterface $fromDate = null,
        public readonly ?\DateTimeInterface $toDate = null,
        public readonly ?bool $onlyValidated = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/listEtickets';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->productId !== null) {
            $data['product_id'] = $this->productId;
        }

        if ($this->locationId !== null) {
            $data['location_id'] = $this->locationId;
        }

        if ($this->fromDate !== null) {
            $data['from_date'] = $this->fromDate->format('Y-m-d');
        }

        if ($this->toDate !== null) {
            $data['to_date'] = $this->toDate->format('Y-m-d');
        }

        if ($this->onlyValidated !== null) {
            $data['only_validated'] = $this->onlyValidated ? 'y' : 'n';
        }

        return $data;
    }
}
