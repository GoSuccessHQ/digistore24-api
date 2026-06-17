<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\BuyerData;

/**
 * Create E-Ticket Request
 *
 * Creates free e-tickets for events.
 */
final class CreateEticketRequest extends AbstractRequest
{
    /**
     * @param BuyerData $buyer Buyer information
     * @param string $productId The product ID
     * @param string $locationId The location ID (see listEticketLocations())
     * @param string $templateId The template ID (see listEticketTemplates())
     * @param \DateTimeInterface $date Event date
     * @param int $days Number of days of the event (minimum: 1)
     * @param string|null $note Optional note (e.g., time)
     * @param int $count Number of e-tickets to create (minimum: 1)
     */
    public function __construct(
        public BuyerData $buyer,
        public string $productId,
        public string $locationId,
        public string $templateId,
        public \DateTimeInterface $date,
        public int $days = 1,
        public ?string $note = null,
        public int $count = 1,
    ) {
        if ($days < 1) {
            throw new \InvalidArgumentException('Days must be at least 1');
        }
        if ($count < 1) {
            throw new \InvalidArgumentException('Count must be at least 1');
        }
    }

    public function getEndpoint(): string
    {
        return '/createEticket';
    }

    public function toArray(): array
    {
        $data = [
            'buyer' => [
                'email' => $this->buyer->email,
            ],
            'product_id' => $this->productId,
            'location_id' => $this->locationId,
            'template_id' => $this->templateId,
            'date' => $this->date->format('Y-m-d'),
            'days' => $this->days,
            'count' => $this->count,
        ];

        // Add optional buyer fields
        if ($this->buyer->title !== null) {
            $data['buyer']['title'] = $this->buyer->title;
        }
        if ($this->buyer->salutation !== null) {
            // createEticket expects a lowercase m/f, unlike the uppercase M/F used elsewhere.
            $data['buyer']['salutation'] = strtolower($this->buyer->salutation->value);
        }
        if ($this->buyer->firstName !== null) {
            $data['buyer']['first_name'] = $this->buyer->firstName;
        }
        if ($this->buyer->lastName !== null) {
            $data['buyer']['last_name'] = $this->buyer->lastName;
        }

        if ($this->note !== null) {
            $data['note'] = $this->note;
        }

        return $data;
    }

    protected function rules(): array
    {
        return [
            'product_id' => 'required',
            'location_id' => 'required',
            'template_id' => 'required',
            'date' => 'required',
        ];
    }
}
